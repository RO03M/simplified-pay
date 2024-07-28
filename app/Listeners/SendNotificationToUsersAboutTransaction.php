<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendNotificationToUsersAboutTransaction {
    public function __construct() {
        //
    }

    public function handle(TransactionCreated $event) {
        $transaction = $event->transaction;
        $response = Http::post("https://util.devi.tools/api/v1/notify");

        if ($response->status() != 204) {
            Log::error("Failed to send notification from transaction {$transaction->id}");
        }
    }
}
