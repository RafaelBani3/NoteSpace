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
        Schema::create('comment', function (Blueprint $table) {
            $table->string('comment_id', 35)->primary(); // Primary Key
            $table->string('notes_id', 35); // Foreign Key
            $table->string('user_id', 35); // Foreign Key
            $table->string('comment_text', 255);
            $table->timestamps();

            // Foreign Key
            $table->foreign('notes_id')->references('notes_id')->on('notes')->onDelete('cascade');

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');

    }
};
