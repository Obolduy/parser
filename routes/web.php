<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LinkCutterLoginController, UserGetSalesController};

Route::get('/', function () {
    return view('main');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/logout', [LinkCutterLoginController::class, 'logout']);
Route::post('/login/checkdata', [LinkCutterLoginController::class, 'checkLogin']);
Route::get('/getsales', [UserGetSalesController::class, 'userGetSales']);
Route::get('/getsales/table', [UserGetSalesController::class, 'userGetExcel']);