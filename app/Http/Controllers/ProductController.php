<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $product = Product::all();
        return response()->json(['success'=>true,'AllProducts'=>$product], 200);
    }

    public function addingProduct(Request $request)
    {
        $productValidation = Validator::make($request->all(), [
            'name' => 'required|string|max:14',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|min:5',
        ]);
        if ($productValidation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $productValidation->errors()
            ], 422);
        }
        $productData = $productValidation->validated();
        //dump($productData);
        $product = Product::create([
            'name'=> $productData['name'],
            'quantity' => $productData['quantity'],
            'price' => $productData['price'],
            'description' => $productData['description'],
        ]);
        return response()->json($product, 200);
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if(!$product){
           return response()->json(['success'=>false,'message'=>'product doesnot found'], 401);
        }
        $product->delete();
        return response()->json(['success'=>true,'deletedProduct'=>$product], 200);
    }

    public function updateProduct(Request $request , $id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['success'=>false,'message'=>'product doesnot found'], 401);
        }
        $product->update($request->all());
        return response()->json(['success'=>true,'updatedProduct'=>$product], 200);
    }
}
