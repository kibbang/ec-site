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

    public function showDirectBuyPrice(Request $request, string $productId )

    {
        $fromView = $request->fromView;
        $product = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url')
        ->where('products.id', $productId)
        ->first();

        return response()->json(['product' => $product]);
    }

    public function cardSelect(Request $request)
    {
        $user = Auth::user();
        $cards = DB::table('cards')
        ->join('users', 'users.id', 'cards.user_id')
        ->select('cards.id', 'cards.number')
        ->where('user_id', '=', $user->id)
        ->get();

        return response()->json(['cards' => $cards]);
    }

    public function directBuy(Request $request) 
    {        
        $counter = $request->counter;        
        $user = Auth::user();
        $productInfo = $request['product'];
        $product = Product::find($productInfo);
        $fromView = $request->fromView;

        try
        {
            DB::transaction(function () use($product,$counter,$user,$productInfo,$fromView){
                if($fromView=='productInfoView'){
                    $product->update([
                        'stock' => $product->stock - $counter
                    ]);
                }
            });
        }

        catch (Exception $e)
        {
            throw $e;
        }

        return response()->json(['product' => $product]);
    }

    public function cartBuy(Request $request)
    {
        
        $fromView = $request->fromView;
        $user = Auth::user();
        $cartInfo = DB::table('carts')
        ->join('products','products.id','carts.product_id')
        ->select('carts.quantity','carts.product_id','products.stock')
        ->where('user_id', '=', $user->id)
        ->get();
        
        try
        {
            DB::transaction(function () use($fromView,$cartInfo,$user){
                if($fromView=='cartView'){
                    foreach($cartInfo as $key => $newStock){
                        
                        $newStock = $cartInfo[$key]->stock - $cartInfo[$key]->quantity;
                        
                        Product::where('products.id', '=', $cartInfo[$key]->product_id )
                        ->update([
                            'stock' =>  $newStock
                        ]);                            
                    }   
                    DB::table('carts')
                    ->where('user_id', '=', $user->id)
                    ->delete();                   
                }
            });
        }

        catch (Exception $e)
        {
            throw $e;
        }

        return response()->json(['status' => 20000]);
    }
}