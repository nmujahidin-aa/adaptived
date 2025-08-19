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
        Schema::create('assesment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assesment_variable_id')->nullable();
            $table->text('question')->nullable();
            $table->foreign('assesment_variable_id')->references('id')->on('assesment_variables')->onDelete('cascade');
            $table->enum('type', ['essay', 'short_answer'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesment_questions');
    }
};
