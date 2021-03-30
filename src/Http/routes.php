<?php

use Illuminate\Support\Facades\Route;
use Olssonm\Ampersand\Http\Controllers\PostController;

Route::name('ampersand.')->group(function (): void {
    Route::get(config('ampersand.url'), [PostController::class, 'index'])->name('index');
    Route::get(config('ampersand.url') . '/{post}', [PostController::class, 'show'])->name('show');
});
