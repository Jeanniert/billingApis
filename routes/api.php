<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;

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


Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function (){
        Route::resource('customer', CustomerController::class);
        Route::resource('company', CompanyController::class);
        Route::resource('invoice', InvoiceController::class);Route::get('report/{invoice_id}', [InvoiceController::class, 'report']);
        Route::get('logout', [AuthController::class, 'logout']);
    });

