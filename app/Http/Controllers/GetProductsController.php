<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class GetProductsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['message' => 'deu certo']);
    }
}
