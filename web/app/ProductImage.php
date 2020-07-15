<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
    protected $fillable=[
        'id',
        'product_id',
        'image_url'   
    ];

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }


    public function getUrlAttribute()
    {
        return asset("storage/product_images/{$this->filename}");
    }
}
