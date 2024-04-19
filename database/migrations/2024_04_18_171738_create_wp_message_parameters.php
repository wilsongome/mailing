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
        Schema::create('wp_message_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_from', 100);
            $table->string('parameter_type', 100);
            $table->string('parameter_data_type', 100);
            $table->string('static_text_value', 60)->nullable();
            $table->bigInteger('wp_document_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('wp_message_parameters');
    }
};
