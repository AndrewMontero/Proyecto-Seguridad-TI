<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/crear', [ProductoController::class, 'create']);
Route::post('/productos/guardar', [ProductoController::class, 'store']);
