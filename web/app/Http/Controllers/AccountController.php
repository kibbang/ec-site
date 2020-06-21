<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Cart;
use Auth;

class AccountController extends Controller
{
    //
    public function showCartPrice(Request $request)

    {
        $carts = $request['carts'];
        
        return response()->json(['carts' => $carts]);
    }

    public function showDirectBuyPrice(Request $request)

    {
        $product = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url')
        ->where('products.id', $productId)
        ->first();

        return response()->json(['product' => $product]);
    }
    
    /////以下はまだ進行中です。/////
    public function cardSelect(Request $request)
    {
        $cards = $request['cards'];

        return response()->json(['cards' => $cards]);
    }

    public function buySuccess(Request $request)
    {

    }

}