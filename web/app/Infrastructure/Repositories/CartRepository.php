<?php

namespace App\Infrastructure\Repositories;

use App\Cart;
use Auth;
use App\Domain\Repositories\ICartRepository;

class CartRepository implements ICartRepository
{
    /**
     * カートに品物を追加
     */
    public function addCart($product, $quantity)
    {
        $user = Auth::user();

        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product['id'],
            'quantity' => $quantity
        ]);

        return $cart;
    }
    /**
     * ユーザーのカートにある商品を表示（代表画像1枚表示）
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
     */
    public function deleteCart($id)
    {
        $cart = Cart::find($id)->delete();
    }
    
}