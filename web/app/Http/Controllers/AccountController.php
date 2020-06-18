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
    public function showPrice($id)
    {
       \Log::debug('aaa');
        $user = Auth::user();
        \Log::debug(request()->all());
        $data = $request['product'];
        \Log::debug($data);

        $productPrice = DB::table('products')
        ->select('products.price')
        ->where('products.id', $id);

        $account = $productPrice->get();
        \Log::debug($productPrice);

        return response()->json(['account'=>$account]);
    }
}
