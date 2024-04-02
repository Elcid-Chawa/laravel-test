<?php

namespace App\Http\Controllers;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request){

        $data = $request->validate([
            'product_name' => 'required|max:255',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);
        
        
        try {

            $product = Product::create($data);

            
            if(Storage::disk('public')->exists('data.json')){
                $oldData = json_decode(Storage::disk('public')->get('data.json'));
            } else {
                $oldData = [];
            }

            $jsondata = array_merge([$product], $oldData);
            Storage::disk('public')->put('data.json', json_encode($jsondata));

            return response()->json(['data' => $jsondata], 201);
        } catch (Exception $e) {
            throw new HttpException(400, COULD_NOT_CREATE_RESOURCE);
        }
        
    } 

    public function show(){
        $products = Product::all();

        return view('form', compact('products'));
    }
}
