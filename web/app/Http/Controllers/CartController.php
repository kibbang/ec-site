<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Auth;
use DB;

class CartController extends Controller
{
    //
    function addCart(Request $request)
    {        
        $user = Auth::user();
        
        $product = $request['product'];

        $quantity = $request->counter;
    
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product['id'],
            'quantity' => $quantity
        ]);

        return response()->json(['cart' => $cart]);
    }

    function viewCart(Request $request)
    {
        $user = Auth::user();
    
        $cartInfo = DB::table('carts')
        ->join('products','products.id','carts.product_id')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('carts.*', 'products.name', 'products.price', 'product_images.image_url', 'products.stock')
        ->where('user_id', '=', $user->id);

        $carts = $cartInfo->get();

        return response()->json(['carts'=>$carts]);
    }

    function deleteCart(Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'delete successfully']);

    }
}