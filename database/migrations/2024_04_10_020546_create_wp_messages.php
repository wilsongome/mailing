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
        Schema::table('wp_messages', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('wp_account_id');
            $table->bigInteger('wp_number_id');
            $table->bigInteger('wp_chat_id');
            $table->bigInteger('contact_id');
            $table->string('wp_message_id', 100);
            $table->text('body');
            $table->string('message_status', 45)->nullable();
            $table->json('message_status_history')->nullable();
            $table->dateTime('send_time')->nullable();
            $table->string('direction', 3)->nullable();
            $table->string('user', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('wp_messages');
    }
};
