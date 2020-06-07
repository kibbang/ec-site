<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    //Product Register
    public function register(Request $request){
        $data = $request->all();

        try {
            DB::transaction(function () use($data) {
                $product = App\Product::create($data['product']);
                $data['product_image']['product_id'] = $product->id;
                App\ProductImage::create($data['product_image']);
            });
        } catch (Exception $e) {
            throw $e;
        }
        
        return response()->json(['status' => 200000]);
    
    }
    //
    public function list(Request $request){
        $data = $request->all();
        $query = DB::table('products')
        ->join('product_images','product_images.product_id','products.id')
        ->select('products.*','product_images.image_url');
        if (!empty($data['search'])) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        $products = $query->get();

        return response()->json(['products' => $products]);
    }
    //
    public function image_upload(){
        $request = request()->all();
        \Log::debug(request());
        //$file_name = $request->file->getClientOriginalName();
       // \Log::debug(getClientOriginalName());
        //$url = request()->file(['file_info'])->storeAs('public/', $file_name);
        $storage = 'public';
        $base64Context = $request['file_info'];
        $dir = '/';

        try {
            preg_match('/data:image\/(\w+);base64,/', $base64Context, $matches);
            $extension = $matches[1];

            $img = preg_replace('/^data:image.*base64,/', '', $base64Context);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);

            $dir = rtrim($dir, '/').'/';
            $fileName = md5($img);
            $path = $dir.$fileName.'.'.$extension;

            Storage::disk($storage)->put($path, $fileData);

        } catch (Exception $e) {
            Log::error($e);
            return null;
        }


        // $file_data = $request['file_info'];
        // $data = base64_decode($file_data);
        // $file_name = 'image_' . time() . '.jpg';

        // \Log::debug(finfo_buffer(finfo_open(), $data, FILEINFO_EXTENSION));
        // if ($file_data != "") {
        //     Storage::disk('public')->put($file_name, $data);
        // }
        
        return response()->json(['image_url' => Storage::disk('public')->url($path)]); 
    }
    //
    public function detail($id){
        $product = DB::table('products')
        ->join('product_images','product_images.product_id','products.id')
        ->select('products.*','product_images.image_url')
        ->where('products.id',$id)
        ->get();

        return response()->json(['product' => $product]);
    }
    //
    public function update(Request $request){
        $productInfo = $request['product'];

        $product = Product::find($productInfo['id']); 
        \Log::debug($product);

        //\Log::debug( $productInfo['name']); 
        $product-> update([
            'name' => $productInfo['name'],
            'quntity' => $productInfo['quntity'],
            'price' => $productInfo['price'],
            'description' => $productInfo['description']
        ]);
        //\Log::debug( $productInfo); 
             
        return response()->json(['product' => $product]);
        where('productID','[0-9]+');
    }
    //
    public function productId(Request $request, string $productId){
        $product = DB::table('products')
        ->join('product_images','product_images.product_id','products.id')
        ->select('products.*','product_images.image_url')
        ->where('products.id',$productId)
        ->first();

        Log::debug($request->all());

        return response()->json(['product' => $product]);
        where('productId', '[0-9]+');
    }

}
