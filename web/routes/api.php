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

Route::prefix('/product')->group(function() {

    Route::post('/register', 'ProductsController@productRegister');

    Route::get('/list', 'ProductsController@productList');

    Route::post('/imageupload', 'ProductsController@imageUpload');

    Route::get('/list/{product}', 'ProductsController@productDetail');

    Route::post('/update', 'ProductsController@productUpdate');

    Route::get('{product_id}', 'ProductsController@productInfo');

});

Route::post('/card', 'CardController@cardRegister');

Route::get('/card','CardController@cardInfo');


Route::post('/cart', 'CartController@addCart');

Route::get('/cart', 'CartController@viewCart');

Route::delete('/cart/{cart}', 'CartController@deleteCart');


Route::get('/account', 'AccountController@showCartPrice');

Route::get('/account/{product}', 'AccountController@showDirectBuyPrice');

Route::get('/account/card', 'AccountController@cardSelect'); 

Route::post('/account/stock/{product}', 'AccountController@buySuccess');


Route::post('/account/stock', 'AccountController@cartBuySuccess');
Route::delete('account/cart', 'AccountController@cartBuySuccess');