<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    public function payerTransactions() {
        return $this->hasMany(Transaction::class, "payer_id", "id");
    }

    public function payeeTransactions() {
        return $this->hasMany(Transaction::class, "payee_id", "id");
    }
}
