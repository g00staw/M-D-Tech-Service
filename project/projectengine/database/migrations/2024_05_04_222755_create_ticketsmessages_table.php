<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticketmessages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('message_content');
            $table->timestamp('sent_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticketmessages');
    }
};
