<?php

declare(strict_types=1);

namespace App\Domain\Entities;

class ProductImage
{
    private $id;
    private $product_id;
    private $image_url;

    //
    public function __construct(
        int $id,
        int $product_id,
        string $image_url
    ){
        $this->id = $id;
        $this->product_id = $product_id;
        $this->image_url = $image_url;
    }

    public function product_id(): int
    {
        return $this->product_id;
    }

    public function image_url(): string
    {
        return $this->image_url;
    }

    public function toArray(): array
    {
        return[
            'id' => $this->id,
            'product_id' => $this->product_id,
            'image_url' => $this->image_url
        ];
    }
}