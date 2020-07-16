<?php

namespace App\Infrastructure\Repositories;

use App\Product;
use App\ProductImage;
use App\Domain\Repositories\IProductRepository;
use DB;

class ProductRepository implements IProductRepository
{
    /**
     * 商品の登録処理
     * @param array $data
     */
    public function productRegister($data)
    {
        try
        {
            DB::transaction(function () use($data) {

                $product = Product::create($data['product']);

                foreach ($data['image_url'] as $image_url) {

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $image_url
                    ]);
                }
            });
        } 
        
        catch (Exception $e)
        { 
            throw $e;
        }
    }
    
    /**
     * 商品の一覧と検索
     * @param array $data
     * @return array $products
     */
    public function showProductList($data)
    {
        $query = Product::select();

        if (!empty($data['search'])) {
            $query->where('name', 'like', '%' . $data['search'] . '%');
        }
        $products = $query->with('productImage')->get();

        return $products;
    }

    /**
     * 管理者用の商品の詳細情報ページを表示
     * @param int $id
     * @return array $product
     */
    public function showProductForAd($id)
    {
        $query = Product::select()->where('id', '=', $id);
        $product = $query->with('productImage')->first();

        return $product;
    }

    /**
     * ユーザー用の商品の詳細情報ページ表示
     * @param int $productId
     * @return array $product
     */
    public function showProductForUser($productId)
    {
        $query = Product::select()->where('id', '=', $productId);
        $product = $query->with('productImage')->first();

        return $product;
    }

    /**
     * 商品の情報アップデート
     * @param array $productInfo
     * @return object $product
     */
    public function productUpdate($productInfo)
    {
        $product = Product::find($productInfo['id']);
        
        $product->update([
            'name' => $productInfo['name'],
            'stock' => $productInfo['stock'],
            'price' => $productInfo['price'],
            'description' => $productInfo['description']
        ]);

        return $product;
    }

    /**
     * 商品の削除
     * @param int $id
     */
    public function productDelete($id)
    {   
        ProductImage::where('product_id', '=', $id)
        ->delete();

       $product = Product::find($id)->delete();      
    }
}