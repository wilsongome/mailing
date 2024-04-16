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
            $table->bigInteger('wp_chat_id');
            $table->string('local_file_path');
            $table->string('local_file_name');
            $table->string('link');
            $table->string('external_id');
            $table->string('type');
            $table->integer('size');
            $table->string('file_extension');
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
