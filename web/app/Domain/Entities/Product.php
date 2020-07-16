<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class Product
{
    private $id;
    private $shop_id;
    private $name;
    private $price;
    private $stock;
    private $description;

    //
    public function __construct(
        int $id,
        int $shop_id,
        string $name,
        int $price,
        int $stock,
        string $description
    ){
        $this->id = $id;
        $this->shop_id = $shop_id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->description = $description;
    }

    public function getShopId(): int
    {
        return $this->shop_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return[
            'id' => $this->id,
            'shop_id' => $this->shop_id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'description' => $this->description
        ];
    }
}