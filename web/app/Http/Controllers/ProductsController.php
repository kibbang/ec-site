<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    //

    public function index()
    {
        return Product::get(); //Product::orderBy('id', 'desc')->first();
    }

    public function store(Request $request)
    {
        \Log::info($request->all());
        $exploded = explode(',',$request->image);
        $decoded = base64_decode($exploded[1]);
        if(str_contains($exploded[0],'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';

        $fileName = str_random().'.'.$extension;

        $path = public_path().'/'.$fileName;

        file_put_contents($path,$decoded);

        $product = Product::create($request->all());
        return $product;
    }

    public function show(Product $product)
    {
        return $product;
    }
}
