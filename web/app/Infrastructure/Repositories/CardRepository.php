<?php

namespace App\Infrastructure\Repositories;

use App\Card;
use App\Domain\Entities\Card as CardEntity;
use Auth;
use App\Domain\Repositories\ICardRepository;

class CardRepository implements ICardRepository
{
    /**
     * カード登録
     * @param array $data
     * @return object $card
     */
    public function cardRegister($data): Card
    {
        $user = Auth::user();

        $card = Card::create([
            'user_id' => $user->id,
            'number' => $data['number'],
            'security_code' =>$data['security_code']
        ]);

        return $card;
    }

    /**
     * ユーザーのカード情報取得
     * @return array cards
     */
    public function viewCard() : array
    {
        $user = Auth::user();

        $cardInfos = Card::where('user_id', '=', $user->id)
        ->get();

        foreach ($cardInfos as $cardInfo) {
            # code...
            $card = new CardEntity(
                $cardInfo->id,
                $cardInfo->user_id,
                $cardInfo->number,
                $cardInfo->security_code
           );

           $cards[] = $card;
        }
        return $cards;
        
    }
    
}