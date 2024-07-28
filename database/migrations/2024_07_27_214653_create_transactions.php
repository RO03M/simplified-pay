<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->double("value");
            $table->enum("transaction_type", ["default", "inserted_by_system"])->default("default");
            $table->foreignUuid("payee_id")->references("id")->on("users");
            $table->foreignUuid("payee_wallet_id")->references("id")->on("wallets");
            $table->foreignUuid("payer_id")->nullable()->references("id")->on("users");
            $table->foreignUuid("payer_wallet_id")->nullable()->references("id")->on("wallets");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
