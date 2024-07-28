<?php

namespace App\Models;

use App\Events\TransactionCreated;
use App\Exceptions\Transactions\NotEnoughMoneyException;
use App\Exceptions\Transactions\UnauthorizedTransaction;
use App\Services\Transactions\MakeTransactionService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class TransactionType {
    const DEFAULT = "default";
    const SYSTEM = "inserted_by_system";
}

class Transaction extends Model {
    use HasFactory, HasUuids;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "value",
        "transaction_type",
        "payer_id",
        "payee_id",
        "payer_wallet_id",
        "payee_wallet_id"
    ];

    protected $attributes = [
        "transaction_type" => TransactionType::DEFAULT
    ];

    public $afterCommit = true;

    // protected $dispatchesEvents = [
    //     "created" => TransactionCreated::class
    // ];

    public function payeeWallet() {
        return $this->belongsTo(Wallet::class, "payee_wallet_id", "id");
    }

    public function payerWallet() {
        return $this->belongsTo(Wallet::class, "payer_wallet_id", "id");
    }
}
