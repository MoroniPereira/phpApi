<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\ExameController;

Route::get('/users', [UserController::class, 'users']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'user']);
Route::middleware('auth:sanctum')->put('/user/{id}', [UserController::class, 'editUser']);
Route::middleware('auth:sanctum')->delete('/user/{id}', [UserController::class, 'deleteUser']);

Route::middleware('auth:sanctum')->get('/consultas', [ConsultaController::class, 'consultas']);
Route::middleware('auth:sanctum')->get('/consulta/{id}', [ConsultaController::class, 'buscarConsulta']);
Route::middleware('auth:sanctum')->post('/consulta', [ConsultaController::class, 'registerConsulta']);
Route::middleware('auth:sanctum')->put('/consulta/{id}', [ConsultaController::class, 'updateConsulta']);
Route::middleware('auth:sanctum')->delete('/consulta/{id}', [ConsultaController::class, 'deleteConsulta']);

Route::middleware('auth:sanctum')->get('/notificacoes', [NotificacaoController::class, 'notification']);
Route::middleware('auth:sanctum')->get('/notificacoe/{id}', [NotificacaoController::class, 'buscarNotification']);
Route::middleware('auth:sanctum')->post('/notificacao', [NotificacaoController::class, 'createNotification']);
Route::middleware('auth:sanctum')->put('/notificacao/{id}', [NotificacaoController::class, 'updateNotification']);
Route::middleware('auth:sanctum')->delete('/notificacao/{id}', [NotificacaoController::class, 'deleteNotification']);

Route::middleware('auth:sanctum')->get('/exames', [ExameController::class, 'exames']);
Route::middleware('auth:sanctum')->post('/exame', [ExameController::class, 'registerExame']);
Route::middleware('auth:sanctum')->put('/exame/{id}', [ExameController::class, 'updateExame']);
Route::middleware('auth:sanctum')->delete('/exame/{id}', [ExameController::class, 'deleteExame']);