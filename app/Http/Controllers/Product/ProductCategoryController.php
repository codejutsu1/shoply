<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\CategoryCollection;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->success(new CategoryCollection($categories));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Category $category)
    {
        //Interacting with many-to-many relationship.
        //Attach(keeps on attaching with duplicates), sync(Attach but detachs), syncWithoutDetaching

        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->success(new ProductCollection($product->categories));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Category $category)
    {
        $product->categories()->findOrFail($category->id);

        $product->categories()->detach($category->id);

        return $this->success(new ProductCollection($product->categories));
    }
}
