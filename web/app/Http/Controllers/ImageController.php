<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductImageService;


class ImageController extends Controller
{
    //
    private $productImage;

    public function __construct(ProductImageService $productImage)
    {
        $this->productImage = $productImage;
    }


    /**
    * 商品画像登録
    * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function imageUpload(Request $request)
    {
        $file_info = $request['file_info'];

        $image_url = $this->productImage->imageUpload($file_info);

        return response()->json(['image_url' => $image_url]);
    }
}
