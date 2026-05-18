<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->enum('status', ['still_missing', 'found', 'claimed'])
                ->default('still_missing')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'claimed'])
                  ->default('pending')
                  ->change();
        });
    }
};