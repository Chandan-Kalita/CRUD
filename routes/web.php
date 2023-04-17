<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class,'index']);
Route::post('/login-submit', [LoginController::class,'login_submit']);

Route::group(['middleware'=>['sessionAuth']], function(){
    
    Route::get('/dashboard', [ItemController::class, 'index']);
    Route::view('/add-new', 'add_new');
    Route::post('/insert', [ItemController::class, 'insert']);
    Route::post('/update', [ItemController::class, 'update']);
    Route::get('/delete', [ItemController::class, 'delete']);
    Route::get('/edit', [ItemController::class, 'edit']);

});