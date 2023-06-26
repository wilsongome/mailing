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
        Schema::create("contact_lists", function(Blueprint $table){
            $table->id();
            $table->bigInteger("campaign_id")->unsigned();
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("CASCADE");
            $table->bigInteger("email_template_id")->unsigned();
            $table->foreign("email_template_id")->references("id")->on("email_templates")->onDelete("RESTRICT");
            $table->string("name");
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop("contact_lists");
    }
};
