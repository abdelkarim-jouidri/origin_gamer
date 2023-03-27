<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return auth()->user()->plainTextToken;
        // return Product::with('category')->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('act-on-product');
        
        $fields = $request->validate([
            'titre'=>'required|min:3',
            'description'=>'required',
            'prix'=>'required',
            'contenu'=>'required',
            'category_id'=>'required|numeric'

        ]);

        $fields['user_id'] = auth()->user()->id;
        $product = Product::create($fields);
        return response([
            'message'=>'product created successfully',
            'product : '=> $product
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //

        $product->category = $product->category ;
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('act-on-product');
        $fields = $request->validate(
            [
                'name'=>'required|min:3',
                'description'=>'required|min:3',
                'price'=>'required',
                'category_id'=>'nullable|numeric'
            ]
            );

            $product->update($fields);
            return response([
                'message'=>'product updated successfully',
                'new product : '=> $product
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Gate::authorize('act-on-product');
        $product->delete();
        return response([
            'message'=>'product deleted successfully'
        ]);
    }

    public function filter($id){
        $category = Category::find($id);
        if(!$category){
            return response(['message'=>'No available categories for the given query']);
        }
        return $category->products;

    }
}
