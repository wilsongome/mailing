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
        Schema::table('contact_lists', function (Blueprint $table) {
            $table->integer('registers', false, true)->default(0)->nullable(false);
            $table->integer('processed_registers', false, true)->default(0)->nullable(false);
            $table->string('status', 100)->nullable(false)->default('STAND_BY');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_lists', function (Blueprint $table) {
            $table->dropColumn('registers');
            $table->dropColumn('processed_registers');
            $table->dropColumn('status');
        });
    }
};
