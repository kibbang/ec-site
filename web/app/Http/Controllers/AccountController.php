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
    public function showCartPrice(Request $request)

    {
        $carts = $request['carts'];
        
        return response()->json(['carts' => $carts]);
    }

    public function showDirectBuyPrice(Request $request, string $productId )

    {
        $product = DB::table('products')
        ->join('product_images', 'product_images.product_id', 'products.id')
        ->select('products.*', 'product_images.image_url')
        ->where('products.id', $productId)
        ->first();

        return response()->json(['product' => $product]);
    }

    /////以下はまだ進行中です。/////
    public function cardSelect(Request $request)
    {
        $user = Auth::user();
        $cards = DB::table('cards')
        ->join('users', 'users.id', 'cards.user_id')
        ->select('cards.id', 'cards.number')
        ->where('user_id', 'like', '%' .$user->id. '%')
        ->get();
        
        return response()->json(['cards' => $cards]);
    }

    public function buySuccess(Request $request, String $productId)
    {
        $user = Auth::user();
        $productInfo = $request['product'];
        $counter = $request->counter;

        \Log::debug($user);

        DB::transaction(function () {
            try{
                DB::table('products')
                ->where('products.id', $productId)
                ->update(['products.stock' => $counter--]);

                DB::table('carts')
                ->where('user_id', 'like', '%' .$user->id. '%')
                ->delete();
            }
            catch(Exception $e)
            {
                throw $e;
            }

            return response()->json(['status' => 200000]);
        });
    }

}