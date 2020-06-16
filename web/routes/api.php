<?php
use App\Cart;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use App\Card;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Illuminate\Support\Facades\Storage;

//use Symfony\Component\Routing\Route;

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
    Route::post('/register', 'ProductsController@productRegister');

    Route::get('/list', 'ProductsController@productList');

    Route::post('/imageupload', 'ProductsController@imageUpload');

    Route::get('/list/{product}', 'ProductsController@productDetail');

    Route::post('/update', 'ProductsController@productUpdate');

    Route::get('{product_id}', 'ProductsController@productInfo');
   /* Route::get('/search',function (Request $request) {
        \Log::debug($request->get('aaa'));
        $search = $request->get('/search');
        //\Log::debug($request->get('/search'));
        $product = DB::table('products')
        ->select('products.*')
        ->where('name', 'like', '%'.$search.'%')
        ->first();
        //\Log::debug($request->get('/search'));
        return response()->json(['product' => $product]);
    });*/

});

Route::post('/card', 'CardController@cardRegister');

Route::post('/cart', 'CartController@addCart');

Route::get('/cart', 'CartController@viewCart');

Route::delete('/cart/{cart}', 'CartController@deleteCart');


//Route::post('/card', 'CardController@register');


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

//Route::patch('/user/{user}', function(App\User $user,Request $request){

    //$user->update($request->user);

    //return response()->json(['user' => $user]);

//});

/*Route::get('/image',function (Request $request) {
    
    //$products = App\Product::all();
    $product_images = App\ProductImage::all();
    
    return response()->json(['product_images' => $product_images]);

});*/
