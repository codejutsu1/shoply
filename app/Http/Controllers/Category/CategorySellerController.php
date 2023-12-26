<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerCollection;

class CategorySellerController extends Controller
{
    public function index(Category $category)
    {
        $sellers = $category->products()
                            ->with('seller')
                            ->get()
                            ->pluck('seller')
                            ->unique()
                            ->values();

        return $this->success(new SellerCollection($sellers));
    }
}
