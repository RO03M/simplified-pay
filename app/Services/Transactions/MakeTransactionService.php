<?php

namespace App\Services\Transactions;

use App\Exceptions\Transactions\NotEnoughMoneyException;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Http;

class MakeTransactionService {
    public function isAuthorizedToTransaction() {
        $response = Http::get("https://util.devi.tools/api/v2/authorize");

        return $response->status() == 200;
    }

    public function updateWallets(Transaction $transaction) {
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