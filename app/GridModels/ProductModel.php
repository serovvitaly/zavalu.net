<?php

namespace App\GridModels;

class ProductModel extends ViewModel
{
    public $table = 'products';

    protected $fillable = ['article', 'brand', 'category', 'title', 'weight', 'price'];

    protected $fields = [
        'id' => [
            'title' => 'ID'
        ],
        'article' => [
            'title' => 'Артикул'
        ],
        'group_id' => [
            'title' => 'Группа'
        ],
        'category' => [
            'title' => 'Категория'
        ],
        'title' => [
            'title' => 'Наименование'
        ],
        'description' => [
            'title' => 'Описание',
            'widget' => [
                'form' => 'textarea'
            ]
        ],
        'weight' => [
            'title' => 'Вес/объем'
        ],
        'price' => [
            'title' => 'Цена'
        ],
        'brand' => [
            'title' => 'Брэнд',
            'widget' => [
                'grid' => 'link'
            ]
        ],
        'base_image_id' => [
            'title' => 'Главная картинка'
        ],
        'active' => [
            'title' => 'Активен'
        ],
        'created_at' => [
            'title' => 'Время создания'
        ],
        'updated_at' => [
            'title' => 'Время изменения'
        ],
    ];
    
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
            ->where('active', '=', 1)
            ->get();

        return $products;
    }

    public function getPrice()
    {
        return number_format($this->price, 2, ',', ' ');
    }

    public function getImage()
    {
        if ( ! $this->base_image_id ) {

            return null;
        }

        return \App\Models\MediaModel::findOrFail($this->base_image_id)->file_name;
    }

    public function images()
    {
        return $this->hasMany('\App\Models\MediaModel', 'product_id')->where('type', '=', 'img');
    }

    public function rivals_links()
    {
        return $this->hasMany('App\Models\RivalLinkModel', 'product_id');
    }
}
