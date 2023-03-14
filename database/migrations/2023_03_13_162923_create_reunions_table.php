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
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('subtitre')->nullable();
            $table->string('type')->nullable();
            $table->string('context');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('quota')->unique();
            $table->string('image');
            $table->string('status')->default("Ouvert");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
