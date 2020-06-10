<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;

class CartController extends Controller
{
    //
    function addCart(Request $request)
    {
        
    \Log::debug(request()->all());
    $data = $request['cart']; //리퀘스트 요청한 cart정보가 배열형태로 들어가 있음

    $user = Auth::user();
    \Log::debug($user);
    $product = $request['product']; //리퀘스트 요청한 product의 정보가 배열형태로 들어가있음
   
    \Log::debug($product); //로그
    $cart = Cart::create([
        'user_id' => $user->id,
        'product_id' => $product['id'],
        'quntity' => $data['quntity']
    ]);
    \Log::debug($cart);

	return response()->json(['cart' => $cart]);
    }
}
