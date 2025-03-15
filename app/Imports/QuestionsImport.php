<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\SubjectQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;

class QuestionsImport implements ToModel
{
    protected $subjectId;
    protected $errors = [];

    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    /**
     * Validate and import question data from an Excel row.
     *
     * @param array $row
     * @return Question|null
     */
    public function model(array $row)
    {
        // Ensure row has exactly 6 elements (Question + 4 Options + Correct Answer)
        if (count($row) < 6) {
            $this->logError("Invalid row format: Missing values", $row);
            return null;
        }

        // Validate question text
        if (empty(trim($row[0]))) {
            $this->logError("Question text cannot be empty", $row);
            return null;
        }

        // Validate options
        for ($i = 1; $i <= 2; $i++) {
            if (empty(trim($row[$i]))) {
                $this->logError("Option {$i} cannot be empty", $row);
                return null;
            }
        }

        // Validate correct answer (Must be between 1 and 4)
        $correctIndex = (int) $row[5];
        if ($correctIndex < 1 || $correctIndex > 4) {
            if ($row[0] != 'Question') {
                $this->logError("Invalid correct option: Must be between 1 and 4", $row);
            }
            return null;
        }

        // Check if question already exists
        $existingQuestion = Question::where('text', $row[0])
            ->where('subject_id', $this->subjectId)
            ->first();

        if ($existingQuestion) {
            $this->logError("Duplicate question: Question already exists", $row);
            return null;
        }

        try {
            // Create question
            $question = Question::create([
                'text' => $row[0],
                'subject_id' => $this->subjectId,
            ]);

            // Associate with subject
            SubjectQuestion::create([
                'question_id' => $question->id,
                'subject_id' => $this->subjectId,
            ]);

            // Create options
            for ($i = 1; $i <= 4; $i++) {
                QuestionOption::create([
                    'option' => $row[$i],
                    'is_correct' => ($i == $correctIndex),
                    'question_id' => $question->id,
                ]);
            }

            return $question;
        } catch (\Exception $e) {
            $this->logError("Database error: " . $e->getMessage(), $row);
            return null;
        }
    }

    /**
     * Log import errors.
     *
     * @param string $message
     * @param array $row
     */
    private function logError($message, $row)
    {
        $errorDetails = [
            'error' => $message,
            'row_data' => $row,
        ];

        // Log the error
        Log::error('Question Import Error', $errorDetails);

        // Store error message for later retrieval (optional)
        $this->errors[] = $errorDetails;
    }

    /**
     * Get import errors (useful for debugging).
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
