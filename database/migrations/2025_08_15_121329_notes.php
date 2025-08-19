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
        Schema::create('notes', function (Blueprint $table) {
            $table->string('notes_id', 35)->primary(); // Primary Key
            $table->string('user_id', 35); // Foreign Key
            $table->string('note_title',255);
            $table->string('note_content', 255);
            $table->enum('note_public', ['Y', 'N']); // Apakah Notes Public atau engga;
            $table->timestamps();

             // Foreign Key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
