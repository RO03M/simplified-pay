<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Exceptions\Transactions\NotEnoughMoneyException;
use App\Models\TransactionType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateWalletsAfterTransaction {
    public function __construct() {
        //
    }

    public function handle(TransactionCreated $event) {
        $transaction = $event->transaction;

        if ($transaction->transaction_type == TransactionType::DEFAULT) {
            $payerWallet = $transaction->payerWallet()->first();

            if (!$payerWallet->hasEnoughMoneyToPay($transaction->value)) {
                throw new NotEnoughMoneyException();
            }
            $payerWallet->decreaseBy($transaction->value)->save();
        }

        $payeeWallet = $transaction->payeeWallet()->first();

        $payeeWallet->increaseBy($transaction->value)->save();
    }
}
