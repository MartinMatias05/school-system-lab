<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('max_points')->default(100);
            $table->dateTime('due_date');
            $table->timestamps();
            $table->index(['course_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
