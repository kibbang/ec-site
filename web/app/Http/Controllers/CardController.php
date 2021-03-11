<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Repositories\ICardRepository;

class CardController extends Controller
{

    private $card;
    public function __construct(ICardRepository $card)
    {
        $this->card = $card;
    }
    
    /**
     * カード登録
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cardRegister(Request $request)
    {
        $data = $request['card'];

        $card = $this->card->cardRegister($data);

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
        $cardInfo = [];
        $cards = $this->card->viewCard();
        foreach($cards as $card)
        {
           $cardInfo[] = $card->toArray();
        }
        
        return response()->json(['cards' => $cardInfo]);
    }
}
