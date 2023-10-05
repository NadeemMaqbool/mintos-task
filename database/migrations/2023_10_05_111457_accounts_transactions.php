<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accounts_transactions', function(Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('sender_account_id');
            $table->string('receiver_account_id');
            $table->timestamps();

            $table->foreign('sender_account_id')
                ->references('account_id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('transaction_id')
                ->references('transaction_id')
                ->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_transactions');
    }
};
