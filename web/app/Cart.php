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
        'quntitiy'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
