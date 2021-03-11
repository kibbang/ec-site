<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class Card
{
    private $id;
    private $user_id;
    private $number;
    private $security_code;

    //
    public function __construct(
        int $id,
        int $user_id,
        string $number,
        string $security_code
    ){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->number = $number;
        $this->security_code = $security_code;
    }
   

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getSecurityCode(): string
    {
        return $this->security_code;
    }

    public function toArray(): array
    {
        return[
            'id' => $this->id,
            'user_id' => $this->user_id,
            'number' => $this->number,
            'security_code' =>$this->security_code
        ];
    }
}