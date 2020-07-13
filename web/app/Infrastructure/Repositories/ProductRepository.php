<?php

namespace App\Infrastructure\Repositories;

use App\Product;
use App\ProductImage;
use App\Domain\Entities\Product as ProductEntity;
use App\Domain\Repositories\IProductRepository;
use DB;

class ProductRepository implements IProductRepository
{
    public function productRegister()
    {
        try
        {
            DB::transaction(function () use($data) {

                $product = Product::create($data['product']);

                foreach ($data['image_url'] as $image_url) {

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $image_url
                    ]);
                }
            });
        } 
        
        catch (Exception $e)
        { 
            throw $e;
        }
    }

    public function imageUpload()
    {
        try 
        {           
            $file_info = $request['file_info'];
            $url = [];  
        
            foreach($file_info as $file)
            {   
                $file_name = $file->getClientOriginalName();

                $file->storeAs('',$file_name);

                $url[] = Storage::disk('public')->url($file_name);
            }
        }

        catch (Exception $e)
        {
            throw $e;
        }
    }
}