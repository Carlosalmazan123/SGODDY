<?php

use App\Http\Controllers\TicketVirtualController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\HasApiTokens;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/obtener-token', [TicketVirtualController::class, 'getAuthToken'])->middleware('auth:sanctum');
