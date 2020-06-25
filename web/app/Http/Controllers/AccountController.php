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
        $user = Auth::user();
        $cards = DB::table('cards')
        ->join('users', 'users.id', 'cards.user_id')
        ->select('cards.id', 'cards.number')
        ->where('user_id', 'like', '%' .$user->id. '%')
        ->get();
        
        return response()->json(['cards' => $cards]);
    }

    public function buySuccess(Request $request) 
    {
        
        $counter = $request->counter;        
        $user = Auth::user();
        $productInfo = $request['product'];
        $product = Product::find($productInfo);

        $fromView = $request->fromView;

        $order = DB::table('carts')
        ->select('carts.quantity','carts.product_id')
        ->where('user_id', 'like', '%' .$user->id. '%')
        ->get();

        
        try
        {

            DB::transaction(function () use($product,$counter,$user,$productInfo,$order,$fromView){
                if($fromView=='productInfoView'){
                    $product->update([
                        'stock' => $product->stock - $counter
                    ]);
                }
                if($fromView=='cartView')
                {
                    $product->update([
                        'stock' => $product->stock - $order->quantity    
                    ])
                    ->where($product->id,'=',$order->product_id);
                    DB::table('carts')
                    ->delete()
                    ->where('user_id','like', '%' .$user->id. '%');
                }                
            });
        }
        catch (Exception $e)
        {
            throw $e;
        }
        return response()->json(['product' => $product]);
    }
    // public function cartBuySuccess(Request $request) 
    // {
    //     \Log::debug('bbb');
    //     $cartInfo = $request['carts'];
    //     \Log::debug($cartInfo);
    //     //$product = Product::find($productInfo);
    //     //\Log::debug($productInfo);
    //     $user = Auth::user();
    //     \Log::debug($user);

         
    // //     try
    // //     {

    // //         DB::transaction(function () use($product,$user,$productInfo){
                
    // //             $product->update([
    // //                 'stock' => $product->stock - $counter
    // //             ]);
    // //             DB::table('carts')
    // //             ->delete()
    // //             ->where('user_id', 'like', '%' .$user->id. '%');
                                
    // //         });
    // //     }
    // //     catch (Exception $e)
    // //     {
    // //         throw $e;
    // //     }
    // //     return response()->json(['product' => $product]);
    // }

}