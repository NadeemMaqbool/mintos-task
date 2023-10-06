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
            $table->string('transaction_id')->unique();
            $table->string('account_id');
            $table->enum('transaction_type', ['debit','credit']);
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->timestamps();

            $table->foreign('account_id')
                ->references('account_id')
                ->on('accounts')
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
