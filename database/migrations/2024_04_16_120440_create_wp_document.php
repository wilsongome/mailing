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
        Schema::create('wp_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wp_chat_id')->nullable();
            $table->string('local_file_path', 500);
            $table->string('local_file_name', 500);
            $table->string('link', 500);
            $table->string('external_id', 100)->nullable();
            $table->string('type', 100);
            $table->integer('size');
            $table->string('file_extension', 100);
            $table->string('wp_type', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('wp_documents');
    }
};
