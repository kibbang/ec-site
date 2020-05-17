<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductImage;

class ImageController extends Controller
{
    //
  
    const IMAGE_DIR = 'public/public/testimg.jpg';

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(StoreImageRequest $request)
    {
        $images = collect([]);

        /** @var UploadedFile $image */
        foreach ($request->getImage() as $image) {
            $filename = $image->store(self::IMAGE_DIR);

            $savedImage = ProductImage::create([
                'filename' => pathinfo($filename, PATHINFO_BASENAME),
                'bytes' => $image->getClientSize(),
                'mime' => $image->getClientMimeType(),
            ]);

            $images->push($savedImage);
        }

        return $images;
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return response()->json([], 204);
    }



    public function upload(Request $request)
    {
        return $request->all();
    }
}
