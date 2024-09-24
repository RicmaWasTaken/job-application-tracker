<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\LeadController;
use App\Http\Middleware\AddUserIdToRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/leads', [LeadController::class, 'index'])->name('leads');
    Route::post('/leads', [LeadController::class, 'create'])->name('leads.create');
    Route::get('/test', function () {
        return view('test');
    })->name('applications.test');
    Route::post('/test', [ApplicationController::class, 'create'])->name('applications.testcreate');
});

require __DIR__.'/auth.php';