<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable=[
        'id',
        'name',
        'email',
        'password',
        'zip_code',
        'address'
    ];
}
