<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $dateTo = $request->input('dateTo');
        $dateFrom = $request->input('dateFrom');
        if ($dateFrom !== null && $dateTo !== null) {
            $model = Income::where('date', '>=', $dateFrom)->where('date', '<=', $dateTo)->orderBy('date', 'desc')->paginate(500);
            return IncomeResource::collection($model);
        } else {
            return response(json_encode(['message' => 'Parameters dateFrom and dateTo is null']));
        }
    }
}
