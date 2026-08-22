<?php

use App\Http\Controllers\EchoTestController;
use App\Livewire\N8nWebhookTester;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('echo/send', [EchoTestController::class, 'send'])->name('echo.send');
Route::get('echo/receive', [EchoTestController::class, 'receive'])->name('echo.receive');
Route::post('echo/broadcast', [EchoTestController::class, 'broadcast'])->name('echo.broadcast');

Route::livewire('n8n/webhook', N8nWebhookTester::class)->name('n8n.webhook');

require __DIR__.'/settings.php';
