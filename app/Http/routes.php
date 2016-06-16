<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', /*'middleware' => 'auth'*/], function(){
    Route::resource('user', 'UserController');
    Route::resource('product', 'ProductController');
    Route::controller('', 'IndexController');
});

Route::controller('card', '\App\Http\Controllers\CardController');

Route::controller('/', 'IndexController');

Route::get('/product-{product_id}', function ($product_id) {

    $product_model = \App\Models\ProductModel::findOrFail($product_id);

    return view('product.card', $product_model->toArray() + ['model' => $product_model]);
});

Route::get('/landing-5667832', function(){
    
    return view('landing.fire-energy');
});