<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable=[
        'name',
        'description',
        'price',
        'quntity',
        'shop_id'
    ];

   /* public function register(array $attributes)
    {
       DB::beginTransaction();
       try{
           $result = $this->fill($attributes)->save();
            DB::commit();
            return $result;
       } catch(\PDOException $e){
           DB::rollback();
           return false;
       }
    }*/

    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

}
