<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model {
    use HasFactory, HasUuids;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "value",
        "user_id"
    ];

    public function hasEnoughMoneyToPay(float $value) {
        return $this->value >= $value;
    }

    public function increaseBy(float $value) {
        $this->value += $value;

        return $this;
    }

    public function decreaseBy(float $value) {
        $this->value -= $value;

        return $this;
    }
}
