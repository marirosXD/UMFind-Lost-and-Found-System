<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('claims', function (Blueprint $table) {
        $table->id();

        $table->foreignId('item_id')->constrained()->onDelete('cascade');

        // CLAIMER (student who receives item)
        $table->string('claimer_first_name');
        $table->string('claimer_last_name');
        $table->string('claimer_student_id');
        $table->string('claimer_contact');

        // RETURNER (who found the item)
        $table->string('returner_first_name')->nullable();
        $table->string('returner_last_name')->nullable();
        $table->string('returner_student_id')->nullable();
        $table->string('returner_contact')->nullable();

        $table->timestamp('claimed_at')->nullable();
        $table->string('status')->default('claimed');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};