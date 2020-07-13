<?php

namespace App\Domain\Repositories;

use App\Card;

interface ICardRepository
{

    public function cardRegister($data): Card;

    public function viewCard() :array; 

}
