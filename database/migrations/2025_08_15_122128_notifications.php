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
        Schema::create('notification', function (Blueprint $table) {
            $table->string('notif_id', 35)->primary(); // Primary Key
            $table->string('user_id', 35); // Foreign Key
            $table->string('type', 100);
            $table->string('message', 255);
            $table->enum('notif_isread', ['Y', 'N']); // Apakah Notes sudah dibaca atau belum;

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
                Schema::dropIfExists('notification');

    }
};
