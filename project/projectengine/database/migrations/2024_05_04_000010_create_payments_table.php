<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('repair_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled']);
            $table->enum('payment_method', ['credit_card', 'paypal', 'cash'])->nullable(); // Dodano 'cash'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
