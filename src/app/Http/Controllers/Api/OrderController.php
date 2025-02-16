<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $dateTo = $request->input('dateTo');
        $dateFrom = $request->input('dateFrom');
        if ($dateFrom !== null && $dateTo !== null) {
            $model = Order::where('date', '>=', $dateFrom)->where('date', '<=', $dateTo)->orderBy('date', 'desc')->paginate(500);
            return OrderResource::collection($model);
        } else {
            return response(json_encode(['message' => 'Parameters dateFrom and dateTo is null']));
        }
    }
}
