<?php
use App\Cart;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Illuminate\Support\Facades\Storage;
//use DB;
//use Exception;
//use Symfony\Component\Routing\Route;

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');



/*Route::get('/products', 'ProductsController@index');

Route::get('/products/{product}', 'ProductsController@show');

Route::get('/cart', 'ProductsCartController@index');

Route::post('/cart', 'ProductsCartController@store');

Route::delete('/cart/{productId}', 'ProductsCartController@destroy');

Route::delete('/cart', 'ProductsCartController@destroyAll');*/

Route::prefix('/product')->group(function() {
    Route::post('/register',function (Request $request) {
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
    
    });

    Route::get('/list',function (Request $request) {
    
        $products = App\Product::all($request->array_product);
        
        return response()->json(['products' => $products]);
    
    });

    Route::post('/imageupload',function(){
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
    });
});





/*Route::post('product/register',function(){
    $request = request()->all();
    \Log::debug($request);

    // must DB-transaction
    //$productImageModel = new App\ProductImage;
    $productModel = app()->make(App\Product::class);
    $productModel->fill($request['product'])->save(); //fill()の中になにが入るか？　array? or attribute?
    
    $product = $productModel->orderBy('id', 'desc')->first();
    
    $file_name = request()->file(['file_info'])->getClientOriginalName();
    
    $url = request()->file->storeAs('public/',$file_name);
    
    $data['product_id'] = $product->id;
    $data['image_url'] = $url;

    $productImageModel = app()->make(App\ProductImage::class);
    $productImageModel->fill($request['image_url'])->save();
    //$productImageModel = App\ProductImage::fill($url)->save(); 
    $product_image = $productImageModel->get();
     

    $productId = App\Product::fill($data)->insertGetId();

    //現在のエラーメッセージ
    //"Non-static method Illuminate\Database\Eloquent\Model::fill() should not be called statically"

    //get(),all() と save(),insertGetId()　

    
    //書き方正しいか??
    //scope??

    $product_image = App\ProductImage::find(1);
    \Log::debug($product_image);
    $product_image->update(['image_url'=>$url]);

    return $product_image;

    //dd(request()->all());

});*/





//Route::resource('products', 'ProductsController');

