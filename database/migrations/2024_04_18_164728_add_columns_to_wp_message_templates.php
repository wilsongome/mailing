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
        Schema::table('wp_message_templates', function (Blueprint $table) {
            $table->string('header_type', 100)->after('language')->nullable();
            $table->string('header_text', 60)->after('header_type')->nullable();
            $table->bigInteger('wp_document_id')->after('header_text')->nullable();
            $table->string('footer_text', 60)->after('header_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wp_message_templates', function (Blueprint $table) {
            $table->dropColumn('header_type');
            $table->dropColumn('header_text');
            $table->dropColumn('header_media');
            $table->dropColumn('footer_text');
        });
    }
};
