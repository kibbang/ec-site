<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    //
	public function register(Request $request)
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
}
