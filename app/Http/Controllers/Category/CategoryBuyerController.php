<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerCollection;

class CategoryBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
                            ->whereHas('transactions')
                            ->with('transactions.buyer')
                            ->get()
                            ->pluck('transactions')
                            ->collapse()
                            ->pluck('buyer')
                            ->unique('id')
                            ->values();

        return $this->success(new BuyerCollection($buyers));
    }
}
