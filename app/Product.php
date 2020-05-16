<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "price", "characteristics"];


    public function characters()
    {
        return $this->hasMany('App\Character');
    }

}
