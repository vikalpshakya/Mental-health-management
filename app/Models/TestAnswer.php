<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'result_id',
        'question_id',
        'selected_option',
        'is_correct'
    ];

    public function result()
    {
        return $this->belongsTo(TestResult::class, 'result_id');
    }

    public function question()
    {
        return $this->belongsTo(TestQuestion::class, 'question_id');
    }
} 