<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AddUserIdToRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', AddUserIdToRequest::class])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::get('/applications/{id}', [ApplicationController::class, 'edit'])->name('applications.edit');
    Route::post('/applications/{id}', [ApplicationController::class, 'applyEdit'])->name('applications.applyEdit');
    Route::get('/applications/{id}/delete', [ApplicationController::class, 'delete'])->name('applications.delete');
    Route::get('/leads', [LeadController::class, 'show'])->name('leads.show');
    Route::post('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::get('/leads/{id}', [LeadController::class, 'edit'])->name('leads.edit');
    Route::post('/leads/{id}', [LeadController::class, 'applyEdit'])->name('leads.applyEdit');
    Route::get('/leads/{id}/delete', [LeadController::class, 'delete'])->name('leads.delete');
    Route::get('/leads/{id}/convert', [LeadController::class, 'convert'])->name('leads.convert');
    Route::get('/test', function () {
        return view('mail.application-alert');
    });
    Route::post('/test', [ApplicationController::class, 'create'])->name('applications.testcreate');
});

require __DIR__.'/auth.php';