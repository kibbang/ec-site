<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use Auth;
use DB;

class CardController extends Controller
{
    /**
     * カード登録
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cardRegister(Request $request)
    {
        
        $data = $request['card'];
    
        $user = Auth::user();

        $card = Card::create([
            'user_id' => $user->id,
            'number' => $data['number'],
            'security_code' => $data['security_code']
        ]);

        return response()->json(['card' => $card]);
    } 

    /**
     * カード番号の表示(カード選択のため)
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cardInfo(Request $request)
    {
        $user = Auth::user();
        $cards = DB::table('cards')
        ->select('cards.number')
        ->where('user_id', '=', $user->id)
        ->get();
        
        return response()->json(['cards' => $cards]);
    }
}
