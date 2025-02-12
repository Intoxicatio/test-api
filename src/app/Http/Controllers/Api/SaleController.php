<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;

class SaleController extends Controller
{
    public function index()
    {
        return SaleResource::collection(Sale::paginate(500));
    }
}
