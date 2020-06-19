<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Cart;
use Auth;

class AccountController extends Controller
{
    //
    public function showPrice(Request $request)
    {
       \Log::debug('aaa');
        $user = Auth::user();
        \Log::debug($user);
        \Log::debug(request()->all());

        $productInfo = $request['product'];
        \Log::debug($request['product']);

        $product = Product::find('id');

        $account = $product['price'];

        return response()->json(['account'=>$account]);
    }
}
