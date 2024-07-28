<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Exceptions\Transactions\UnauthorizedTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class CheckAuthorizationAfterTransaction {
    public function __construct() {
        //
    }
    public function handle(TransactionCreated $event) {
        $response = Http::get("https://util.devi.tools/api/v2/authorize");

        if ($response->status() != 200) {
            throw new UnauthorizedTransaction();
        }
    }
}
