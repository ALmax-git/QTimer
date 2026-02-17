<?php

use App\Http\Controllers\ExamsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Middleware\QTimerRequestCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Subject;
use App\Exports\QuestionsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/subjects/export/all', function () {

    $subjects = Subject::get();

    if ($subjects->isEmpty()) {
        abort(404, 'No subjects found');
    }

    $zipFileName = 'All_Subjects_Questions_' . now()->timestamp . '.zip';
    $zipPath = storage_path('app/private/' . $zipFileName);

    $zip = new \ZipArchive;

    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
        abort(500, 'Could not create zip file.');
    }

    foreach ($subjects as $subject) {

        $fileName = str_replace(' ', '_', $subject->title) . '_questions.xlsx';

        Excel::store(
            new QuestionsExport($subject->id),
            $fileName,
            'local'
        );

        $tempPath = storage_path('app/private/' . $fileName);

        if (file_exists($tempPath)) {
            $zip->addFile($tempPath, $fileName);

            // delete temp excel after adding
            // unlink($tempPath);
        }
    }

    $zip->close();

    if (!file_exists($zipPath)) {
        abort(500, 'Zip file was not created.');
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
});



Route::get('/test', function () {
    return view('test');
});

Route::get('/log_out', function () {
    auth()->logout();
    return redirect()->route('app');
})->name('log_out');
Route::get('/fix-users', function () {

    $users = \App\Models\User::where('is_staff', false)->get();

    foreach ($users as $user) {

        [$username, $domain] = explode('@', $user->email);

        $username = preg_replace('/[\s-]+/', '', $username);

        $user->email = $username . '@' . $domain;
        $user->save();
    }

    return "Users cleaned successfully.";
});

Route::get('/', function () {
    if (!auth()->check()) {
        return view('dashboard');
    }
    if (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master) {
        return view('dashboard');
    } else {
        return view('qtimer');
    }
})->name('app')->middleware(QTimerRequestCounter::class);

Route::get('/qtimer-requests', [RequestController::class, 'trackRequest']);
Route::post('license', [PaymentController::class, 'buy_license'])->name('buy_license');
Route::get('license', [PaymentController::class, 'set_license'])->name('set_license');

// Route::post('/', [UploadController::class, 'questions'])->name('question.upload');
Route::get('/{all}', function ($all) {
    if ($all === 'log_out') {
        auth()->logout();
        return redirect()->route('app');
    }
    return redirect()->route('app');
});
Route::get('/user/profile', function () {
    return redirect()->route('app');
});
Route::prefix('/api/v1/qtimer')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Heartbeat (lightweight keep-alive)
        Route::post('/exams/{exam}/heartbeat', [ExamsController::class, 'heartbeat']);

        // List available exams
        Route::get('/exams', [ExamsController::class, 'index']);

        // Start or Resume exam
        Route::post('/exams/{exam}/start', [ExamsController::class, 'start']);

        // Resume session (optional separate endpoint if needed)
        Route::get('/exams/{exam}/session', [ExamsController::class, 'start']);


        // Submit exam
        Route::post('/exams/{exam}/submit', [ExamsController::class, 'submit']);
    });
