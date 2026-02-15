<?php

use App\Http\Controllers\ExamsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Middleware\QTimerRequestCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('test');
});

Route::get('/log_out', function () {
    Auth::logout();
    return redirect()->route('app');
})->name('log_out');
Route::get('/', function () {
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
Route::get('/{all}', function () {
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
