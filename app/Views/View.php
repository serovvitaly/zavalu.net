<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 02.06.16
 * Time: 14:19
 */

namespace App\Views;


use Illuminate\Database\Eloquent\Model;

class View
{
    protected $model;

    protected $view = 'r5';

    public function __construct($model)
    {
        /**
         * Illuminate\Database\Eloquent\Model
         *
         * Illuminate\Database\Eloquent\Collection
         * Illuminate\Pagination\LengthAwarePaginator
         */

        $this->model = $model;
    }

    public static function make($model)
    {
        $class_name = get_called_class();

        return new $class_name($model);
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function init()
    {
        //
    }

    public function render()
    {
        $this->init();

        return view($this->getView(), ['model' => $this->getModel()]);
    }
}