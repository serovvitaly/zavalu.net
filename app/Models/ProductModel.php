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

    public function getPrice()
    {
        return number_format($this->price, 2, ',', ' ');
    }
}
