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
        Schema::create("mail_template", function(Blueprint $table){
            $table->id();
            $table->bigInteger("campaign_id")->unsigned();
            $table->foreign("campaign_id")->references("id")->on("campaign")->onDelete("CASCADE");
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
        Schema::drop("mail_template");
    }
};
