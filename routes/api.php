<?php

use App\Http\Controllers\ApiGetSalesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('getsales', [ApiGetSalesController::class, 'apiGetSales']);