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
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'returner_first_name',
                'returner_last_name',
                'returner_student_id',
                'returner_contact',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('returner_first_name')->nullable();
            $table->string('returner_last_name')->nullable();
            $table->string('returner_student_id')->nullable();
            $table->string('returner_contact')->nullable();
        });
    }
};