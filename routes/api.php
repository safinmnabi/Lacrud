<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax;
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

Route::get('/', [Ajax::class , 'AllData']);
Route::post('/register', [Ajax::class, 'storeapi']);
Route::get('/delete/{id}', [Ajax::class , 'deleteapi']);
Route::post('/edit', [Ajax::class, 'updateapi']);
Route::post('/loginapi', [Ajax::class, 'loginapi']);
// Route::get('/usershow/{eid}', [Ajax::class, 'usershow'])->middleware('API_AUTH');
Route::get('/usershow/{eid}', [Ajax::class, 'usershow']);

