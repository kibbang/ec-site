<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //

    protected $casts = [
        'quntity' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
