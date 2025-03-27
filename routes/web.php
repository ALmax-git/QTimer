<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestController;
use App\Http\Middleware\QTimerRequestCounter;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');
})->name('app')->middleware(QTimerRequestCounter::class);

Route::get('/qtimer-requests', [RequestController::class, 'trackRequest']);
Route::post('license', [PaymentController::class, 'buy_license'])->name('buy_license');
Route::get('license', [PaymentController::class, 'set_license'])->name('set_license');

// Route::post('/', [UploadController::class, 'questions'])->name('question.upload');
Route::get('/{all}', function () {
    return redirect()->route('app');
});
