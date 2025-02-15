<?php

namespace App\Services;

use App\Jobs\ConnectionJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchService
{
    public function fetch($type)
    {
        $page = 0;
        $today = Carbon::now()->format('Y-m-d');
        if ($type === 'stocks') {
            $tommorow = Carbon::now()->addDay()->format('Y-m-d');
            $url = "89.108.115.241:6969/api/{$type}?dateFrom={$today}&dateTo={$tommorow}&limit=500&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie";
        } else {
            $url = "89.108.115.241:6969/api/{$type}?dateFrom=0001-01-01&dateTo={$today}&limit=500&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie";
        }
        $maxPage  = Http::get($url)->json()['meta']['last_page'];
        while ($maxPage > $page) {
            $page++;
            $urlu = $url . "&page={$page}";
            ConnectionJob::dispatch($type, $urlu);
        }
        return Log::info("Data start to fetching, total pages: {$page} url: {$url}");
    }
}
