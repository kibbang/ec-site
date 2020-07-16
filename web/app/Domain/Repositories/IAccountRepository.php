<?php

namespace App\Domain\Repositories;

interface IAccountRepository
{
    /**
     * 商品をカートに入れずに購入する場合の計算処理のための関数
     * @param int $counter
     * @param int $id
     */
    public function directBuy($counter, $id);

    /**
     * 商品をカートに入れて購入する場合の計算処理のための関数
     */
    public function cartBuy();
}