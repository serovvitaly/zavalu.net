<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    public $table = 'products';

    protected $fillable = ['article', 'brand', 'category', 'title', 'weight', 'price'];
    
    public static function getActiveProducts()
    {
        $products = self::where('active', '=', 1)->get();

        return $products;
    }

    public function getGroupProducts()
    {
        $products = \App\Models\ProductModel::orderBy('weight')
            ->where('group_id', '=', $this->group_id)
            ->where('group_id', '>', 0)
            ->where('id', '<>', $this->id)
            ->get();

        return $products;
    }

    public function getPrice()
    {
        return number_format($this->price, 2, ',', ' ');
    }

    public function getImage()
    {
        //
    }

    public function rivals_links()
    {
        return $this->hasMany('App\Models\RivalLinkModel', 'product_id');
    }
}
