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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->unique();
            $table->enum('account_type', ['saving', 'current']);
            $table->string('currency');
            $table->string('client_id');
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->timestamps();

            $table->foreign('client_id')
                ->references('client_id')
                ->on('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
