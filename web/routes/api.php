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

});

Route::post('/card', 'CardController@cardRegister');

Route::post('/cart', 'CartController@addCart');

Route::get('/cart', 'CartController@viewCart');

Route::delete('/cart/{cart}', 'CartController@deleteCart');

Route::get('/account', 'AccountController@showCartPrice');

Route::get('/account', 'AccountController@showDirectBuyPrice');
