<?php

namespace Database\Seeders;

use App\Models\MentalHealthTest;
use App\Models\TestQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MentalHealthTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the test
        $test = MentalHealthTest::create([
            'title' => 'Depression Screening Test',
            'description' => 'A comprehensive screening test to assess symptoms of depression. This test helps identify potential signs of depression and provides recommendations based on your responses.',
            'total_questions' => 5,
            'is_active' => true
        ]);

        // Create the questions
        $questions = [
            [
                'question' => 'How often do you feel sad or down?',
                'options' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                'points' => 1
            ],
            [
                'question' => 'How often do you have trouble sleeping?',
                'options' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                'points' => 1
            ],
            [
                'question' => 'How often do you feel tired or have little energy?',
                'options' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                'points' => 1
            ],
            [
                'question' => 'How often do you have trouble concentrating?',
                'options' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                'points' => 1
            ],
            [
                'question' => 'How often do you feel hopeless about the future?',
                'options' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                'points' => 1
            ]
        ];

        foreach ($questions as $question) {
            TestQuestion::create([
                'test_id' => $test->id,
                'question' => $question['question'],
                'options' => $question['options'],
                'points' => $question['points']
            ]);
        }
    }
}
