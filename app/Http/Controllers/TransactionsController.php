<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Exceptions\Transactions\NotEnoughMoneyException;
use App\Exceptions\Transactions\UnauthorizedTransaction;
use App\Http\Requests\Transactions\MagicDepositRequest;
use App\Http\Requests\Transactions\TransferRequest;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use App\Services\Transactions\MakeTransactionService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller {
    public function magicDeposit(MagicDepositRequest $request, MakeTransactionService $makeTransactionService) {
        $validatedData = $request->validated();
        $payee = User::with("wallet")->where("id", $validatedData["payee_id"])->first();
    
        $transaction = Transaction::create(array_merge($validatedData, [
            "payee_wallet_id" => $payee->wallet->id,
            "transaction_type" => TransactionType::SYSTEM
        ]));

        $makeTransactionService->updateWallets($transaction);

        return $transaction;
    }

    public function transfer(TransferRequest $request, MakeTransactionService $makeTransactionService) {
        $request->validated();

        DB::beginTransaction();

        try {
            $payer = User::with("wallet")->findOrFail($request->payer_id);
            $payee = User::with("wallet")->findOrFail($request->payee_id);

            $transaction = Transaction::create([
                "payer_id" => $payer->id,
                "payer_wallet_id" => $payer->wallet->id,
                "payee_id" => $payee->id,
                "payee_wallet_id" => $payee->wallet->id,
                "value" => $request->value
            ]);

            event(new TransactionCreated($transaction));

            DB::commit();
            return $transaction;
        } catch(NotEnoughMoneyException $error) {
            DB::rollback();

            return response()->json([
                "failed" => true,
                "message" => "Not enough money"
            ], 400);
        } catch(UnauthorizedTransaction $error) {
            DB::rollback();

            return response()->json([
                "failed" => true,
                "message" => "Unauthorized to make the transaction, try again"
            ], 403);
        } catch(Exception $error) {
            DB::rollback();

            Log::error($error);

            return response()->json([
                "failed" => true
            ], 500);
        }
    }
}
