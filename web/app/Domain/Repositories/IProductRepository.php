<?php

namespace App\Domain\Repositories;

interface IProductRepository
{
    /**
     * 商品登録関数
     * @param array $data
     */
    public function productRegister($data);


    /**
     * 商品一覧のための関数
     * @param array $data
     */
    public function showProductList($data);


    /**
     * 管理者に商品詳細情報を示すための関数
     * @param int $id
     */
    public function showProductForAd($id);


    /**
     * Userに商品詳細情報を示すための関数
     * @param int $productId
     */
    public function showProductForUser($productId);


    /**
     * 商品の情報をアップデートするための関数
     * @param array $productInfo
     */
    public function productUpdate($productInfo);


    /**
     * 商品を削除するための関数
     * @param int $id
     */
    public function productDelete($id);
}