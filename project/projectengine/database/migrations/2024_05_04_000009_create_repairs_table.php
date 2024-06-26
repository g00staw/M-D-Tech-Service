<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->nullable()->constrained();
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['zgłoszone', 'przyjęte', 'w trakcie realizacji', 'oczekiwanie na części', 'ukończono'])->nullable();
            $table->date('report_date');
            $table->date('completion_date')->nullable();
            $table->text('user_notes')->nullable();
            $table->text('repair_title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repairs');
    }
};
