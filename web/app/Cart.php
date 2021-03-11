<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //

    protected $fillable=[
        'id',
        'user_id',
        'product_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
