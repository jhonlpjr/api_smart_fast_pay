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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('cpf');
            $table->foreign('cpf')->references('identity_document')->on('users');
            $table->string('description');
            $table->float('value');
            $table->enum('status', ['pending','payed','due','failed'])->default('pending');
            $table->string('payment_method');
            $table->foreign('payment_method')->references('slug')->on('payment_method');
            $table->timestamp('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
