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
        Schema::create('logs', function (Blueprint $table) {
            $table->string('logs_id', 35)->primary(); // Primary Key
            $table->string('user_id', 35); // Foreign Key
            $table->string('action', 100);
            $table->string('description', 255);
            $table->string('ip_address', 50);
            $table->string('user_agent', 255);


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
        Schema::dropIfExists('logs');
    }
};
