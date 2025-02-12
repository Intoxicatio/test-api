<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;

class StockController extends Controller
{
    public function index()
    {
        return StockResource::collection(Stock::paginate(500));
    }
}
