<?php
declare(strict_types=1);

namespace App\Service;

class ProdcutImageService
{
    public function imageUpload()
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
    }
}