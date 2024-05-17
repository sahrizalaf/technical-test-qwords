<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/check', [\App\Http\Controllers\ApiController::class, 'index'])->name('init');
