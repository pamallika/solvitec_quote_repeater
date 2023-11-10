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
        Schema::drop('valutes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('valutes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('name');
            $table->json('valutes');
            $table->timestamps();
        });
    }
};
