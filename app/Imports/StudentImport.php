<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserSet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    protected $setId;
    protected $errors = [];

    public function __construct($setId)
    {
        $this->setId = $setId;
    }

    /**
     * Validate and import question data from an Excel row.
     *
     * @param array $row
     * @return Question|null
     */
    public function model(array $row)
    {


        // Validate ID text
        if (empty(trim($row[0]))) {
            $this->logError("Student ID Number cannot be empty", $row);
            return null;
        }

        // Validate Name text
        if (empty(trim($row[1]))) {
            $this->logError("Student Name cannot be empty", $row);
            return null;
        }


        // Clean Student ID (remove dash and whitespace)
        $cleanId = preg_replace('/[\s-]+/', '', trim($row[0]));

        // Check if question already exists
        $email_exist = User::where('email', $cleanId . '@cbt.net')
            ->first();
        $id_number_exist = User::where('id_number', $cleanId)
            ->first();

        if ($email_exist || $id_number_exist) {
            $this->logError("Duplicate User: User already exists", $row);
            return null;
        }
        //unique email 4 char randow
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $uniqueEmail = $cleanId . '_' . $randomString . '@cbt.net';

        if (User::where('email', $uniqueEmail)->exists()) {
            $this->logError("Generated email already exists, please try again", $row);
            $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
            $uniqueEmail = $cleanId . '_' . $randomString . '@cbt.net';
        }
        try {
            // Create question
            $user = User::create([
                'name' => $row[1],
                'email' => $uniqueEmail,
                'id_number' => $cleanId,
                'is_staff' => false,
                'is_set_master' => false,
                'is_subject_master' => false,
                'password' => Hash::make('password'),
                'school_id' => Auth::user()->school->id,
            ]);

            // Associate with subject
            UserSet::create([
                'user_id' => $user->id,
                'set_id' => $this->setId,
            ]);


            return $user;
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
        Log::error('Student Import Error', $errorDetails);

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
