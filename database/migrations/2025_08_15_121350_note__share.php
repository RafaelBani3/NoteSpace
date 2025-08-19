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
        Schema::create('note_share', function (Blueprint $table) {
            $table->string('note_share_id', 35)->primary(); // Primary Key
            $table->string('notes_id', 35); // Foreign Key
            $table->string('shared_with_user_id', 35); // Foreign Key
            $table->enum('note_public', ['Y', 'N']); // Apakah Notes Public atau engga;
            $table->timestamps();

            // Foreign Key
            $table->foreign('notes_id')->references('notes_id')->on('notes')->onDelete('cascade');

            $table->foreign('shared_with_user_id')->references('user_id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_share');

    }
};
