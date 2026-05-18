<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasColumn('items', 'student_id')) {
        Schema::table('items', function (Blueprint $table) {
            $table->string('student_id')->nullable();
        });
    }
}

public function down(): void
{
    if (Schema::hasColumn('items', 'student_id')) {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('student_id');
        });
    }
}
};

