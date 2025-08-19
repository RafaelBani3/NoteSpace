<?php

use App\Http\Controllers\Notes\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('auth.login');
    });


    // NOTES 

    Route::prefix('NoteSpace')->group(function () {
        
        // Get All Users
        Route::get('/api/users', [NoteController::class, 'getAllUser'])->name('users.search');
        
        // Create Notes
        Route::post('/Create', [NoteController::class, 'saveNote'])->name('notes.store');

        // ShowPrivateNotes
        Route::get('/PrivateNotes', [NoteController::class, 'showPrivateNotes'])->name('showPrivateNotes');

        // Update Save Private Note yang di edit
        Route::post('/UpdateNote', [NoteController::class, 'updatePrivateNote'])->name('UpdateNote');

        // Delete Note
        Route::delete('/DeleteNote/{note}', [NoteController::class, 'deleteNote'])->name('deleteNote');
   
        // Upload Comment
        Route::post('/notes/{notes}/comment', [NoteController::class, 'uploadComment'])->name('notes.comment');

        // Upload
        Route::get('/notes/{notes}/comments', [NoteController::class, 'getComments'])->name('notes.getComments');

    });

require __DIR__.'/auth.php';
