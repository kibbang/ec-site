<?php
declare(strict_types=1);

namespace App\Services;

use Storage;

class ProductImageService
{
    /**
     * 商品の画像登録
     */
    public function imageUpload($file_info): array
    {
        try 
        {
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

        return $url;
    }
}