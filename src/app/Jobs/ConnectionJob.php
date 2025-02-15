<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConnectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $type, string $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $attempts = 1;
        $success = false;
        while ($attempts <= 3 && !$success) {

            $response = Http::get($this->url);
            if ($response->failed()) {
                Log::alert("Failed to fetch {$this->type}, retrying... Attempt: {$attempts}");
                $attempts++;
                sleep(60);
            } else {
                $success = true;

            $responseData = $response->json()['data'];

            switch ($this->type) {
                case 'orders':
                    PutOrdersJob::dispatch($responseData);
                    return Log::info("Success connection ---> {$this->url}");
                case 'incomes':
                    PutIncomesJob::dispatch($responseData);
                    return Log::info("Success connection ---> {$this->url}");
                case 'sales':
                    PutSalesJob::dispatch($responseData);
                    return Log::info("Success connection ---> {$this->url}");
                case 'stocks':
                    PutStocksJob::dispatch($responseData);
                    return Log::info("Success connection ---> {$this->url}");
                }
            }
        }
        return Log::error('Failed to fetch data');
    }
}
