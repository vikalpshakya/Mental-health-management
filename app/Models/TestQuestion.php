<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question',
        'options',
        'points'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function test()
    {
        return $this->belongsTo(MentalHealthTest::class, 'test_id');
    }
} 