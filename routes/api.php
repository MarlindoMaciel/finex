<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PagamentosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/pagamentos', [PagamentosController::class, 'store'])->name('pagamentos');
Route::get('/pagamento', [PagamentosController::class, 'store'])->name('pagamento');
Route::get('/consultas', [PagamentosController::class, 'index'])->name('consultas');



