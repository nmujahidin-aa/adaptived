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
        Schema::table('group_worksheets', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('worksheet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_worksheets', function (Blueprint $table) {
            $table->dropColumn('grade');            
        });
    }
};
