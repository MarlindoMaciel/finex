<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::post('/login', function(Request $request){
    $credential = $request->only(['email','password']);
    if( Auth::attempt($credential) === false ){
        return response()->json('Acesso não autorizado','401');
    }
    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token');
    return response()->json($token->plainTextToken);
});

Route::middleware('auth:sanctum')->group(function(){

    Route::post('/pagamentos',              [PagamentosController::class, 'store']);
    Route::get('/pagamentos/{id}',          [PagamentosController::class, 'index']);
    Route::get('/delete/pagamentos/{id}',   [PagamentosController::class, 'cancel']);
    Route::patch('/pagamentos/{id}',        [PagamentosController::class, 'confirm']);
    Route::get('/list/pagamentos',          [PagamentosController::class, 'list']);

});


