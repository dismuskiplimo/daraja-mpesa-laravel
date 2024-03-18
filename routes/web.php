<?php

use App\Http\Controllers\{ProfileController, MpesaController, DonationController};

use Illuminate\Support\Facades\Route;

// MPESA
Route::get('/', [MpesaController::class, 'index'])->name('home');
Route::post('/', [MpesaController::class, 'request_stk_push']);
Route::get('/thank-you', [DonationController::class, 'thank_you'])->name("thank_you");
Route::post('/payments/mpesa/callback', [MpesaController::class, 'mpesa_callback'])->name("mpesa_callback");

// Donations
Route::get('/donations', [DonationController::class, 'index'])->name('donations');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
