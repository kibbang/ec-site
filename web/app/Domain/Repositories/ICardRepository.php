<?php

namespace App\Domain\Repositories;

use App\Card;

interface ICardRepository
{
    /**
     * カード登録処理を行う関数
     * 
     * @param array $data
     * @return Card
     */
    public function cardRegister($data): Card;


    /**
     * カード情報取得のための関数
     * 
     * @return array
     */
    public function viewCard() :array; 

}
