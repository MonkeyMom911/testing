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
        Schema::create('selection_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_vacancy_id')->constrained()->cascadeOnDelete();
            $table->string('code')->nullable()->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_stages');
    }
};
