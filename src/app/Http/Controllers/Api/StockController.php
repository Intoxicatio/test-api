<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $dateTo = $request->input('dateTo');
        $dateFrom = $request->input('dateFrom');
        if ($dateFrom !== null && $dateTo !== null) {
            $model = Stock::where('date', '>=', $dateFrom)->where('date', '<=', $dateTo)->orderBy('date', 'desc')->paginate(500);
            return StockResource::collection($model);
        } else {
            return response(json_encode(['message' => 'Parameters dateFrom and dateTo is null']));
        }
    }
}
