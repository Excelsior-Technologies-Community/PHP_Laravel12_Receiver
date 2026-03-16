<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceiverController;

Route::get('/', [ReceiverController::class, 'index']);
Route::get('/receiver/create', [ReceiverController::class, 'create']);
Route::post('/receiver/store', [ReceiverController::class, 'store']);
