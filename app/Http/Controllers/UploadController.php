<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function questions(Request $request)
    {
        $request->validate([
            'questions_file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new QuestionsImport($request->subject_id);
        // dd($request, $import);
        Excel::import($import, request()->file($request->file('questions_file')));

        // Get any errors from the import
        $errors = $import->getErrors();

        if (!empty($errors)) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Some questions were not imported due to errors.',
                'errors' => $errors,
            ]);
        }
        dd($this, $errors, $import);
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Questions imported successfully!',
        ]);
    }
}
