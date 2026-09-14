<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/jobs');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applications.store');

    Route::middleware('can:employer')->prefix('employer')->name('employer.')->group(function (): void {
        Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');
        Route::post('/company', [EmployerController::class, 'storeCompany'])->name('company.store');
        Route::get('/jobs/create', [EmployerController::class, 'createJob'])->name('jobs.create');
        Route::post('/jobs', [EmployerController::class, 'storeJob'])->name('jobs.store');
        Route::get('/jobs/{job}/applications', [EmployerController::class, 'applications'])->name('jobs.applications');
        Route::patch('/applications/{application}', [EmployerController::class, 'updateApplication'])->name('applications.update');
    });
});
