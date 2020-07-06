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
        //\Log::debug($data);

        try
        {
            DB::transaction(function () use($data) {
                $product = Product::create($data['product']);
                $data['product_image']['product_id'] = $product->id;
                ProductImage::create($data['product_image']);
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
        $query = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url');
        if (!empty($data['search'])) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->get();

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
        
        $file_info = $request['file_info'];  
         
        //$file_name = $request->file->getClientOriginalName();
        foreach($file_info as $file)
        {
            $file_name = $file->getClientOriginalName();
            $file->storeAs('',$file_name);
            
        }
        dd($file_name);
       // \Log::debug(getClientOriginalName());
        //$url = request()->file(['file_info'])->storeAs('public/', $file_name);
        $storage = 'public';
        $base64Context = $request['file_info'];
        dd($request->all());
        \Log::debug($request->file);
        $dir = '/';

        try 
        {           
            preg_match('/data:image\/(\w+);base64,/', $base64Context, $matches);
            foreach($matches as $base64Context){
                $extension = $matches[1];
                $img = preg_replace('/^data:image.*base64,/', '', $base64Context);
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);
    
                $dir = rtrim($dir, '/').'/';
                $fileName = md5($img);
                $path = $dir.$fileName.'.'.$extension;
    
                Storage::disk($storage)->put($path, $fileData);
                
            }
            // $img = preg_replace('/^data:image.*base64,/', '', $base64Context);
            // $img = str_replace(' ', '+', $img);
            // $fileData = base64_decode($img);

            // $dir = rtrim($dir, '/').'/';
            // $fileName = md5($img);
            // $path = $dir.$fileName.'.'.$extension;

            // Storage::disk($storage)->put($path, $fileData);
            
            return response()->json(['image_url' => Storage::disk('public')->url($path)]);
        }
        catch (Exception $e)
        {
            throw $e;
        }

        // $file_data = $request['file_info'];
        // $data = base64_decode($file_data);
        // $file_name = 'image_' . time() . '.jpg';

        // \Log::debug(finfo_buffer(finfo_open(), $data, FILEINFO_EXTENSION));
        // if ($file_data != "") {
        //     Storage::disk('public')->put($file_name, $data);
        // }
        
        // return response()->json(['image_url' => Storage::disk('public')->url($path)]); 
    }
    

    /**
     * 商品詳細情報
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productDetail($id)
    {
        $product = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url')
        ->where('products.id', $id)
        ->first();

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
        $product = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url')
        ->where('products.id', $productId)
        ->first();
        
        return response()->json(['product' => $product]);
    }
}