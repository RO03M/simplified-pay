<?php

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("/users")->group(function() {
    Route::post("/", [UserController::class, "create"]);
    Route::prefix("/{userId}")->group(function() {
        Route::get("/wallet", [UserController::class, "walletFromUserId"]);
        Route::get("/transactions", [UserController::class, "transactionsFromUserId"]);
    });
});


Route::prefix("transactions")->group(function() {
    Route::post("/magic-deposit", [TransactionsController::class, "magicDeposit"]);
    Route::post("/transfer", [TransactionsController::class, "transfer"]);
});