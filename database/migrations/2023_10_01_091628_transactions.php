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
        Schema::create('transactions', function(Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('transaction_type');
            $table->string('sender_account_id');
            $table->string('receiver_account_id');
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};