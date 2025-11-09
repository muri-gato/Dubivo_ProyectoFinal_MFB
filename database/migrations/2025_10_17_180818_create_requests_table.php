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
        Schema::create('requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); // ✅ CLIENT_ID
    $table->foreignId('actor_id')->constrained('users')->onDelete('cascade'); // ✅ ACTOR_ID a USERS
    $table->string('subject'); // ✅ FALTA ESTE CAMPO
    $table->text('message');
    $table->string('status')->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
