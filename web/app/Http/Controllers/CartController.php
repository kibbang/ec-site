<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Auth;
use DB;

class CartController extends Controller
{
    /**
     * 商品をカートに追加
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function addCart(Request $request)
    {        
        $user = Auth::user();
                
        $product = $request['product'];
        
        $quantity = $request->counter;

        $cartInfo = DB::table('carts')
        ->select('carts.quantity')
        ->where('user_id', '=', $user->id)
        ->where('product_id', '=', $product['id'])
        ->first();

        if($cartInfo==null){
            Cart::insert([
                'user_id' => $user->id,
                'product_id' => $product['id'],
                'quantity' => $quantity
            ]);
        }

        else{
            Cart::where('product_id', '=', $product['id'])
            ->where('user_id', '=', $user->id) 
            ->update([
                'quantity' => $cartInfo->quantity + $quantity
            ]);
        }

        return response()->json(['status' => 20000]);
    }

    /**
     * カートにある商品表示
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * カートにある商品を削除
     * 
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response     
     */
    function deleteCart(Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'delete successfully']);

    }
}