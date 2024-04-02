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
        Schema::create('wp_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_account_id');
            $table->string('external_id');
            $table->string('name');
            $table->string('number', 15);
            $table->timestamps();
            $table->foreign('wp_account_id')->references('id')->on('wp_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('wp_numbers');
    }
};
