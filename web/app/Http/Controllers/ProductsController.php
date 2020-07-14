<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Repositories\IProductRepository;

class ProductsController extends Controller
{
    private $product;

    public function __construct(IProductRepository $product)
    {
        $this->product = $product;
    }

    /**
     * 商品登録
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function productRegister(Request $request)
    {
        $data = $request->all();

        $this->product->productRegister($data);
        
        return response()->json(['status' => 200000]);
    
    }
    /**
     * 商品情報の表示
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function productList(Request $request)
    {
        $data = $request->all();
        
        $products = $this->product->showProductList($data);

        return response()->json(['products' => $products]);
    }

    /**
     * 商品詳細情報
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productDetail($id)
    {
        $product = $this->product->showProductForAd($id);

        return response()->json(['product' => $product]);
    }

    /**
     * 商品情報の変更
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function productUpdate(Request $request)
    {
        $productInfo = $request['product'];

        $product = $this->product->productUpdate($productInfo);

        return response()->json(['product' => $product]);       
    }
    /**
     * 商品情報の変更のための商品情報の表示
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function productInfo($productId)
    {
       $product = $this->product->showProductForUser($productId);
        
        return response()->json(['product' => $product]);
    }


    /**
     * 商品の削除機能
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productDelete($id)
    {
        $this->product->productDelete($id);

        return response()->json(['message' => 'delete successfully']);
    }

}