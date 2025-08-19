<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Notes\NoteController;

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth.session'])->group(function () {
        

        Route::prefix('NoteSpace')->group(function () {
            
            // View Notes Dashbaord
            Route::get('/Dashboard', [NoteController::class, 'notesView'])->name('notes.dashboard');

        });


    });
