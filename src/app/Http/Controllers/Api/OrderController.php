<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 500);
        $page = $request->query('page', 1);

        $data = Order::paginate($limit, ['*'], 'page', $page);

        $count = Order::count();

        return response()->json([
            'data' => $data->items(),
            'meta' => [
                'total' => $count,
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
            ]
        ], 200);
    }
}
