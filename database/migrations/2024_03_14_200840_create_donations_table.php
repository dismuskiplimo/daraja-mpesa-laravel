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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string("donor_name");
            $table->string("phone");
            $table->string("donation_type");
            $table->string("amount");
            $table->string("donor_note");
            $table->string("merchant_request_id");
            $table->string("checkout_request_id");
            $table->string("mpesa_tansaction_id")->default("");
            $table->boolean("fulfilled")->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
