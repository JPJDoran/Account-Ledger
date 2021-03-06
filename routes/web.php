<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\AccountController::class, 'index'])->name('account');

    Route::post('/accounts/addTransaction', [App\Http\Controllers\AccountController::class, 'newTransaction']);
    Route::post('/accounts/getAccountDetailsAjax', [App\Http\Controllers\AccountController::class, 'getAccountDetailsAjax']);
});
