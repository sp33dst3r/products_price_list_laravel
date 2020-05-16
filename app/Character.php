<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
    public static function filter(){
        //выводим характеристики для фильтра
        $res =  self::all();
        $groups = $res->groupBy('name');

        $arr = $groups->toArray();
        $charArr = [];
        foreach($arr as $items){
            $charArr[$items[0]["name"]] = [];
            foreach($items as $item){
                if(!in_array($item['value'], $charArr[$item["name"]])) array_push($charArr[$item["name"]], $item['value']);
            }

        }

        return $charArr;
    }
}
