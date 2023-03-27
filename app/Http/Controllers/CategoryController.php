<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return Category::with('products')->get();
        return auth()->user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('act-on-category');
        $fields = $request->validate([
            'name'=>'required|min:3'
        ]);

        $cat = Category::create($fields);
        return response(['message'=>'new category added successfully', 'category : '=>$cat]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cat = Category::findOrFail($id);
        $cat['products'] = $cat->products;
        return $cat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('act-on-category');
        $cat = Category::find($id);
        $fields = $request->validate(['name'=>'nullable|required']);
        $cat->update($fields);
        return response(['message'=>'category successfully updated', 'category :'=>$cat]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('act-on-category');
        $cat = Category::find($id);
        $cat->delete();
        return response(['message'=>'category successfully deleted']);
    }
}
