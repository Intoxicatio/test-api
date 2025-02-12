<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 500);
        $page = $request->query('page', 1);

        $data = Stock::paginate($limit, ['*'], 'page', $page);

        $count = Stock::count();

        return response()->json([
            'data' => $data->items(),
            'meta' => [
                'total' => $count,
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
            ]
        ]);
    }
}
