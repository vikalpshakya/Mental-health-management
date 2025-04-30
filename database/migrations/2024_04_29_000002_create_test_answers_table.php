<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->constrained('test_results')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('test_questions')->onDelete('cascade');
            $table->string('selected_option');
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_answers');
    }
}; 