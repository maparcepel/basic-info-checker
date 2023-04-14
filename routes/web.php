<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\CheckController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import-from-prod', [ImportController::class, 'importFromProd']);
Route::get('/import-from-basic-info', [ImportController::class, 'importFromBasicInfo']);
Route::get('/check', [CheckController::class, 'check']);
Route::get('/check_management_type', [CheckController::class, 'checkManagementType']);