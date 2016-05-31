<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CardController extends Controller
{
    public function getBuyOneClick(Request $request)
    {
        $product_id = (int) $request->get('product_id');

        return $product_id;
    }
}
