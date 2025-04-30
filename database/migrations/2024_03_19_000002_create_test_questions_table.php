<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('mental_health_tests')->onDelete('cascade');
            $table->text('question');
            $table->json('options');
            $table->integer('points');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_questions');
    }
}; 