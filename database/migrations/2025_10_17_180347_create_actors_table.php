<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('audio_path')->nullable();
            
            // MÚLTIPLE SELECCIÓN (JSON)
            $table->json('genders')->nullable(); // ['Masculino', 'Femenino']
            $table->json('voice_ages')->nullable(); // ['Niño', 'Adolescente', 'Adulto joven']
            
            // BOOLEANO (sí/no)
            $table->boolean('is_available')->default(true);
            
            $table->json('voice_characteristics')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actors');
    }
};