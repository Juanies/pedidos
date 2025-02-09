<?php

use App\Http\Controllers\InicioController;
use App\Livewire\ShowUserOrder;
use Illuminate\Support\Facades\Route;

Route::get("/", [InicioController::class, "index"])->name("inicio");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get("/user-order", ShowUserOrder::class)->name("user-order");

});
