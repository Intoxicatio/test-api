<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $dateTo = $request->input('dateTo');
        $dateFrom = $request->input('dateFrom');
        if ($dateFrom !== null && $dateTo !== null) {
            $model = Sale::where('date', '>=', $dateFrom)->where('date', '<=', $dateTo)->orderBy('date', 'desc')->paginate(500);
            return SaleResource::collection($model);
        } else {
            return response(json_encode(['message' => 'Parameters dateFrom and dateTo is null']));
        }
    }
}
