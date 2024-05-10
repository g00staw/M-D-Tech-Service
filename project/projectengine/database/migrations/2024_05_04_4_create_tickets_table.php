<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('employee_id')->constrained('employees');
            $table->string('subject');
            $table->text('problem_description');
            $table->enum('status', ['open', 'in_progress', 'closed']);
            $table->timestamp('creation_date');
            $table->timestamp('closing_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
