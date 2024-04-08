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
        Schema::create('wp_chats', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('wp_account_id');
            $table->unsignedBigInteger('wp_number_id');
            $table->unsignedBigInteger('contact_id');
            $table->dateTime('first_contact_message');
            $table->dateTime('last_contact_message');
            $table->string('status');
            $table->timestamps();
            $table->string('created_by');
            $table->foreign('wp_account_id')->references('id')->on('wp_accounts')->onDelete('cascade');
            $table->foreign('wp_number_id')->references('id')->on('wp_numbers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropT('wp_chats');
    }
};
