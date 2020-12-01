<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\UserController::class, 'login'])
    ->name('login');

Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:sanctum');

Route::get('user', [\App\Http\Controllers\UserController::class, 'showAuthenticated'])
    ->name('user')
    ->middleware('auth:sanctum');

Route::apiResource('companies', \App\Http\Controllers\CompanyController::class);
Route::apiResource('employees', \App\Http\Controllers\EmployeeController::class);
