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

Schema::create('actor_work', function (Blueprint $table) {
    $table->id();
    $table->foreignId('actor_id')->constrained()->onDelete('cascade');
    $table->foreignId('work_id')->constrained()->onDelete('cascade');
    $table->string('character_name')->nullable(); // nombre del personaje que hizo
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_work');
    }
};