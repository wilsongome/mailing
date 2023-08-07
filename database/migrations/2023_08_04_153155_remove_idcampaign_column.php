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
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropForeign('email_templates_campaign_id_foreign');
            $table->dropColumn('campaign_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->integer('campaign_id')->after('id');
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("CASCADE");
        });
    }
};
