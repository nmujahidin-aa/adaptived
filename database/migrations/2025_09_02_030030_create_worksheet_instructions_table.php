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
        Schema::create('worksheet_instructions', function (Blueprint $table) {
            $table->id();
            $table->text('instruction')->nullable();
            $table->foreignId('worksheet_id')->nullable()->constrained('worksheets')->onDelete('cascade');
            $table->string('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheet_instructions');
    }
};
