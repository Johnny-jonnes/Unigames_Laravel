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
        Schema::create('matchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipe_a_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('equipe_b_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('discipline_id')->constrained('disciplines')->onDelete('cascade');
            $table->foreignId('edition_id')->constrained('editions')->onDelete('cascade');
            $table->dateTime('date_match');
            $table->string('lieu')->nullable();
            $table->string('phase')->default('Poules'); // Poules, Quart, Demi, Finale
            $table->integer('score_a')->nullable();
            $table->integer('score_b')->nullable();
            $table->enum('statut', ['planifie', 'en_cours', 'joue'])->default('planifie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchs');
    }
};
