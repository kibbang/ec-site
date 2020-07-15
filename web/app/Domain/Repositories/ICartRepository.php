<?php

namespace App\Domain\Repositories;

interface ICartRepository
{
    /**
     * カートに品物を追加するため
     * @param $product, $quantity
     */
    public function addCart($product, $quantity);

    /**
     * ユーザーのカートにある商品を表示するため
     */
    public function viewCart();

    /**
     * カートにある商品を削除するため
     * @param $id
     */
    public function deleteCart($id);
}