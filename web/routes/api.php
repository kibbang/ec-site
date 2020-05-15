<?php
use App\Cart;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\HttpCache\Store;
//use Symfony\Component\Routing\Route;

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', fn() => Auth::user())->name('user');



Route::get('/products', 'ProductsController@index');

Route::get('/products/{product}', 'ProductsController@show');

Route::get('/cart', 'ProductsCartController@index');

Route::post('/cart', 'ProductsCartController@store');

Route::delete('/cart/{productId}', 'ProductsCartController@destroy');

Route::delete('/cart', 'ProductsCartController@destroyAll');



Route::post('/product',function (Request $request) {
	
	$product = App\Product::create($request->product);
	
	return response()->json(['product' => $product]);

});

Route::get('/product/list',function (Request $request) {
	
	$products = App\Product::all($request->array_product);
	
	return response()->json(['products' => $products]);

});

/*Route::post('fileupload',function(){
	$request = request()->all();
	$file_name = request()->file->getClientOriginalName();
	$url = request()->file->storeAs('public/',$file_name);

	
	return $url;
});

Route::post('product/register',function(){
	$request = request()->all();
	\Log::debug($request);

	// must DB-transaction
	//$productImageModel = new App\ProductImage;
	$productModel = app()->make(App\Product::class);
	$productModel->fill($request['Product'])->save(); //fill()の中になにが入るか？　array? or attribute?
	
	$product = $productModel->orderBy('id', 'desc')->first();
	
	$file_name = request()->file->getClientOriginalName();
	
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

