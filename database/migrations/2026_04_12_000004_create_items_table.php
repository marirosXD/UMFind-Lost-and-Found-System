<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('items', function (Blueprint $table) {
        $table->id(); 

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('title');
        $table->text('description');
        $table->string('category');
        $table->string('location');
        $table->date('date_found');

        $table->string('image')->nullable();
        $table->string('attachment')->nullable();

        $table->string('first_name');
        $table->string('last_name');
        $table->string('student_id');
        $table->string('contact_number');

        $table->enum('status', ['still_missing', 'received', 'claimed'])
            ->default('still_missing');

        $table->timestamps(); 
    });
}

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};