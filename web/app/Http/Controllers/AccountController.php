<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Cart;
use Auth;

class AccountController extends Controller
{
    /**商品をカートに入れずに直接購入する場合実行**/
    public function directBuy(Request $request, $id) 
    {        
        $counter = $request->counter;        
        $product = Product::find($id);
                
        try
        {
            DB::transaction(function () use($product,$counter){
                $product->update([
                    'stock' => $product->stock - $counter
                ]);                
            });
        }

        catch (Exception $e)
        {
            throw $e;
        }

        return response()->json(['status' => 20000]);
    }

    /**カートにある商品を購入する場合に実行**/
    public function cartBuy(Request $request)
    {
        $user = Auth::user();
        $cartInfo = DB::table('carts')
        ->join('products','products.id','carts.product_id')
        ->select('carts.quantity','carts.product_id','products.stock')
        ->where('user_id', '=', $user->id)
        ->get();
        
        try
        {
            DB::transaction(function () use($cartInfo,$user)
            {
                foreach($cartInfo as $key => $orderInfo)
                {                       
                    $newStock = $orderInfo->stock - $orderInfo->quantity;
                        
                    Product::where('products.id', '=', $orderInfo->product_id )
                    ->update([
                        'stock' =>  $newStock
                    ]);                            
                }   
                DB::table('carts')
                ->where('user_id', '=', $user->id)
                ->delete();                                  
            });
        }

        catch (Exception $e)
        {
            throw $e;
        }

        return response()->json(['status' => 20000]);
    }
}