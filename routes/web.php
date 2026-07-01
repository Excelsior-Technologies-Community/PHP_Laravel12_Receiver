<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceiverController;

Route::get('/', [ReceiverController::class, 'index'])->name('home');
Route::get('/receiver/create', [ReceiverController::class, 'create'])->name('receiver.create');
Route::post('/receiver/store', [ReceiverController::class, 'store'])->name('receiver.store');
Route::get('/receiver/{id}', [ReceiverController::class, 'show'])->name('receiver.show');
Route::get('/receiver/{id}/edit', [ReceiverController::class, 'edit'])->name('receiver.edit');
Route::put('/receiver/{id}', [ReceiverController::class, 'update'])->name('receiver.update');
Route::delete('/receiver/{id}', [ReceiverController::class, 'destroy'])->name('receiver.destroy');
Route::post('/receiver/{id}/read', [ReceiverController::class, 'markAsRead'])->name('receiver.markRead');
Route::post('/receiver/bulk-delete', [ReceiverController::class, 'bulkDelete'])->name('receiver.bulkDelete');

Route::post('/receiver/{id}/reply', [ReceiverController::class, 'sendReply'])->name('receiver.reply');
Route::get('/analytics/data', [ReceiverController::class, 'getAnalyticsData'])->name('analytics.data');