<?php

use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('app');
})->name('app');

Route::post('license', [PaymentController::class, 'buy_license'])->name('buy_license');
Route::get('license', [PaymentController::class, 'set_license'])->name('set_license');

// Route::post('/', [UploadController::class, 'questions'])->name('question.upload');
Route::get('/{all}', function () {
    return redirect()->route('app');
});
