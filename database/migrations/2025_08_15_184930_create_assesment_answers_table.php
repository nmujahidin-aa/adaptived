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
        Schema::create('assesment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('assesment_question_id')->nullable();
            $table->text('answer')->nullable();

            $table->foreign('user_id', 'fk_assesment_answers_user')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('assesment_question_id', 'fk_assesment_answers_question')
                ->references('id')->on('assesment_questions')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesment_answers');
    }
};
