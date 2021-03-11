<?php

namespace App\Infrastructure\Repositories;

use DB;
use App\Cart;
use Auth;
use App\Domain\Repositories\ICartRepository;

class CartRepository implements ICartRepository
{
    /**
     * カートに品物を追加
     * @param array $product
     * @param int $quantity
     */
    public function addCart($product, $quantity)
    {
        $user = Auth::user();

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
    }
    /**
     * ユーザーのカートにある商品を表示（代表画像1枚表示）
     * @return array $carts
     */
    public function viewCart()
    {
        $user = Auth::user();

        $query = Cart::select()->where('user_id', '=', $user->id);

        $carts = $query->with('product.productImage')->get();
        
        return $carts;
    }

    /**
     * カートにある商品を削除
     * @param int $id
     */
    public function deleteCart($id)
    {
        $cart = Cart::find($id)->delete();
    }
    
}