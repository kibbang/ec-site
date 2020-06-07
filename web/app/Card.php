<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $fillable=[
        'id',
        'user_id',
        'number',
        'security_code'
    ];
}
