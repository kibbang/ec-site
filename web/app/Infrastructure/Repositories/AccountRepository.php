<?php

namespace App\Infrastructure\Repositories;

use DB;
use Auth;
use App\Product;
use App\Domain\Repositories\IAccountRepository;

class AccountRepository implements IAccountRepository
{
    /**
     * 商品をカートに入れずに購入する場合の計算処理
     * @param int $counter
     * @param int $id
     */
    public function directBuy($counter, $id)
    {
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
    }

    /**
     * 商品をカートに入れて購入する場合の計算処理
     */
    public function cartBuy()
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
    }
}