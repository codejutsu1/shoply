<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class CategoryProductController extends Controller
{
    public function index(Category $category)
    {
        $products = $category->products;

        return $this->success(new ProductCollection($products));
    }
}
