<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\Users\GetWalletFromUserRequest;
use App\Http\Requests\Users\TransactionsFromUserIdRequest;
use App\Models\User;
use App\Models\Wallet;

class UserController extends Controller {
    public function create(CreateUserRequest $request) {
        $user = User::create($request->validated());

        $wallet = Wallet::create([
            "value" => 0,
            "user_id" => $user->id
        ]);

        $user->wallet = $wallet;

        return [
            "user" => $user
        ];
    }

    public function walletFromUserId(GetWalletFromUserRequest $request) {
        $user = User::where("id", $request->userId)->first();

        return $user->wallet()->first();
    }

    public function transactionsFromUserId(TransactionsFromUserIdRequest $request) {
        $user = User::where("id", $request->userId)->first();

        return [
            "payeeTransactions" => $user->payeeTransactions()->get(),
            "payerTransactions" => $user->payerTransactions()->get()
        ];
    }
}
