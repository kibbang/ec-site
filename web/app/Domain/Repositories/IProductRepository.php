<?php

namespace App\Domain\Repositories;

use App\Product;

interface IProductRepository
{
    /**
     * 商品登録関数
     * @param $data
     */
    public function productRegister($data);


    /**
     * 商品一覧のための関数
     * @param $data
     */
    public function showProductList($data);


    /**
     * 管理者に商品詳細情報を示すための関数
     * @param $id
     */
    public function showProductForAd($id);


    /**
     * Userに商品詳細情報を示すための関数
     * @param $productId
     */
    public function showProductForUser($productId);


    /**
     * 商品の情報をアップデートするための関数
     * @param $productInfo
     */
    public function productUpdate($productInfo);


    /**
     * 商品を削除するための関数
     * @param $id
     */
    public function productDelete($id);
}