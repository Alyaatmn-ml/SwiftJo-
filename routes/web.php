<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('jobs.index');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('jobs', JobController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
    Route::delete('/jobs/{job}/apply', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
    

    Route::post('/chatbot', [ChatbotController::class, 'respond'])->name('chatbot.respond');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/admin/candidates', [JobController::class, 'adminCandidates'])->name('admin.candidates');
        Route::get('/admin/applications', [JobApplicationController::class, 'index'])->name('admin.applications');
    });
});