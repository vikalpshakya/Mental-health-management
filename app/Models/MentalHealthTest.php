<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentalHealthTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'total_questions',
        'is_active'
    ];

    public function questions()
    {
        return $this->hasMany(TestQuestion::class, 'test_id');
    }

    public function results()
    {
        return $this->hasMany(UserTestResult::class, 'test_id');
    }
} 