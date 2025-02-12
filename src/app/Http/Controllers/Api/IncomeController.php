<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;

class IncomeController extends Controller
{
    public function index()
    {
        return IncomeResource::collection(Income::paginate(500));
    }
}
