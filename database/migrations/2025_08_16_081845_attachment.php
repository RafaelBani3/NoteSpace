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
        Schema::create('attachment', function (Blueprint $table) {
            $table->string('attachment_id', 35)->primary(); // Primary Key
            $table->string('notes_id', 35); // Foreign Key
            $table->string('attachment_filename', 500);
            $table->string('attachment_realname', 500);
            $table->string('file_type', 100);

            $table->timestamps();

            // Foreign Key
            $table->foreign('notes_id')->references('notes_id')->on('notes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
