<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use DB;
use Storage;

class ProductsController extends Controller
{
    /**
     * 商品登録
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function productRegister(Request $request)
    {
        $data = $request->all();

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
        // $query = DB::table('products')
        // ->join('product_images', 'product_images.product_id', 'products.id')
        // ->select('products.*', 'product_images.image_url');

        $query = Product::select();

        if (!empty($data['search'])) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->with('productImage')->get();

        return response()->json(['products' => $products]);
    }

    /**
     * 商品画像登録
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        try 
        {           
            $file_info = $request['file_info'];
            $url = [];  
        
            foreach($file_info as $file)
            {   
                $file_name = $file->getClientOriginalName();

                $file->storeAs('',$file_name);

                $url[] = Storage::disk('public')->url($file_name);
            }
        }

        catch (Exception $e)
        {
            throw $e;
        }

        return response()->json(['image_url' => $url]);
    }
    

    /**
     * 商品詳細情報
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productDetail($id)
    {
        $query = Product::select()->where('id', '=', $id);
        $product = $query->with('productImage')->first();

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

        $product = Product::find($productInfo['id']);
        
        $product->update([
            'name' => $productInfo['name'],
            'stock' => $productInfo['stock'],
            'price' => $productInfo['price'],
            'description' => $productInfo['description']
        ]);

        return response()->json(['product' => $product]);       
    }
    /**
     * 商品情報の変更のための商品情報の表示
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $productId
     * @return \Illuminate\Http\Response
     */
    public function productInfo(Request $request, string $productId)
    {
        $query = Product::select()->where('id', '=', $productId);
        $product = $query->with('productImage')->first();
        
        return response()->json(['product' => $product]);
    }
}