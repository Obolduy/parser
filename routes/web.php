<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LinkCutterLoginController, UserGetSalesController};

Route::get('/', function () {
    return view('main');
});
Route::match(['POST', 'GET'], '/login', [LinkCutterLoginController::class, 'loginviaapi']);
Route::get('/getsales', [UserGetSalesController::class, 'userGetSales']);
Route::get('/getsales/table', [UserGetSalesController::class, 'userGetExcel']);