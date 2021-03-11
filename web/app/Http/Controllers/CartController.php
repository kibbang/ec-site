<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Repositories\ICartRepository;

class CartController extends Controller
{
    private $cart;

    public function __construct(ICartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * 商品をカートに追加
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function addCart(Request $request)
    {        
        $product = $request['product'];
        
        $quantity = $request->counter;

        $this->cart->addCart($product, $quantity);

        return response()->json(['status' => 20000]);
    }

    /**
     * カートにある商品表示
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function viewCart(Request $request)
    {
        $carts = $this->cart->viewCart();

        return response()->json(['carts'=>$carts]);
    }

    /**
     * カートにある商品を削除
     * 
     * @param int $id
     * @return \Illuminate\Http\Response     
     */
    function deleteCart($id)
    {
        $this->cart->deleteCart($id);

        return response()->json(['message' => 'delete successfully']);
    }
}