<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GetProductsController extends Controller
{
    public function __invoke(Request $request)
    {
        $currentPage = $request->get('page') ?? 1;
        $key = 'product_' . $currentPage;
        return Cache::remember($key, null, function () {
            return Product::paginate();
        });
    }
}
