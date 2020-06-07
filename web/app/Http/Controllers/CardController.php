<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    //
    public function register(Request $request){
        
    $data = $request['card'];
	
	$user = Auth::user();

	$card = App\Card::create([
		'user_id' => $user->id,
		'number' => $data['number'],
		'security_code' => $data['security_code']
	]);

	\Log::debug($card);

	return response()->json(['card' => $card]);
    }
}
