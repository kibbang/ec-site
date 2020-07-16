<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Repositories\IAccountRepository;

class AccountController extends Controller
{
    private $account;
    public function __construct(IAccountRepository $account)
    {
        $this->account = $account;
    }

    /**
     * 商品をカートに入れずに直接購入する場合実行
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function directBuy(Request $request, $id) 
    {        
        $counter = $request->counter;

        $this->account->directBuy($counter, $id);

        return response()->json(['status' => 20000]);
    }

    /**
     * カートにある商品を購入する場合に実行
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cartBuy(Request $request)
    {
        $this->account->cartBuy();

        return response()->json(['status' => 20000]);
    }
}