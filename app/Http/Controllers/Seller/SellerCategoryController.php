<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;

class SellerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
                            ->whereHas('categories')
                            ->with('categories')
                            ->get()
                            ->pluck('categories')
                            ->collapse()
                            ->unique('id')
                            ->values();

        return $this->success(new CategoryCollection($categories));
    }
}
