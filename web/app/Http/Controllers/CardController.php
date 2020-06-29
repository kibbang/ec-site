<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use Auth;
use DB;

class CardController extends Controller
{
    //
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

    public function cardInfo()
    {
        $user = Auth::user();
        $cards = DB::table('cards')
        ->join('users','users.id', 'cards.user_id')
        ->select('cards.*')
        ->where('user_id', '=', $user->id)
        ->get();
        
        return response()->json(['cards' => $cards]);
    }
}
