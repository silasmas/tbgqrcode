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
        Schema::create('reunion_participans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participan_id')->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
        $table->foreignId('reunion_id')->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('status')->default("Valide");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunion_participans');
    }
};
