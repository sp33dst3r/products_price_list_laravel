<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Character;
use File;

class ProductController extends Controller
{
    public function create(Request $request){
        $file = $request->data;

        if ($request->hasFile('data')) {
            $products = json_decode(file_get_contents($file->getRealPath()));
            Product::query()->delete();
            Character::query()->delete();
              //раз остаются только новые - проще просто подчистить таблицу (без проверки на каждый запрос), по ресурсам это менее накладно
            foreach($products as $prod){
                $product = new Product();
                $product->name = $prod->name;
                $product->real_id = $prod->id;
                $product->price = $prod->price;
                $product->save();

                foreach($prod->characteristics as $k=>$v){
                    $characteristics = new Character();
                    $characteristics->name = $k;
                    $characteristics->value = $v;
                    $product->characters()->save($characteristics);
                }
            }
            return redirect('/results');
        }
    }

    public function createSoft(Request $request){
        //файл из storage
        $filename = 'prods.json';
        $path = storage_path('app/public/' . $filename);


        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);



        if ($file) {

            $products = json_decode($file);

            foreach($products as $prod){
                $product = Product::where('real_id', $prod->id)->first();

                if($product){

                    $product->characters()->delete(); //обновляем характеристики

                }else{
                    $product = new Product();



                }

                $product->name = $prod->name;
                $product->price = $prod->price;
                $product->real_id = $prod->id;
                $product->save();
                foreach($prod->characteristics as $k=>$v){
                    $characteristics = new Character();
                    $characteristics->name = $k;
                    $characteristics->value = $v;
                    $product->characters()->save($characteristics);
                }

            }

            return redirect('/results');

        }
    }

    public function results (Request $request){
        $chars = Character::filter();
        \DB::enableQueryLog();
        $products = Product::whereHas('characters', function($query) use ($request) {
            $filteredChars = $request->chars;
            if($filteredChars){
                $count = 0;
                foreach($filteredChars as $k => $v){
                    $or  = ($count == 0) ? 'and' : 'or';
                    $query->whereRaw("name=? and value in (?)", [$k, implode(',', $v)], $or);
                    $count++;
                }
            }
        });
        if($request->name){
            $products->where("name", 'like', "%".$request->name."%");
        }
        if($request->order){
            $by = ($request->order == 'asc') ? 'asc' : 'desc';
            $products->orderBy('price', $by);
        }
        $res =  $products->get();
        return view("results", array("products"=>$res, "chars" => $chars));
    }
}
