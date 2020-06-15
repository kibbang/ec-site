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
        
        $data = $request['cart']; //리퀘스트 요청한 cart정보가 배열형태로 들어가 있음

        $user = Auth::user();
        
        $product = $request['product']; //리퀘스트 요청한 product의 정보가 배열형태로 들어가있음
    
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product['id'],
            'quntity' => $data['quntity']
        ]);

        return response()->json(['cart' => $cart]);
    }

    function viewCart(Request $request)
    {
        $user = Auth::user();
    
        $cartInfo = DB::table('carts')
        ->join('products','products.id','carts.product_id')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('carts.*', 'products.name', 'products.price', 'product_images.image_url')
        ->where('user_id', 'like', '%' .$user->id. '%');

        $carts = $cartInfo->get();

        return response()->json(['carts'=>$carts]);
    }

    function deleteCart(App\Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'delete successfully']);

    }
}
