<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todo;
use App\Http\Controllers\Ajax;
use App\Http\Controllers\Login;

/// Normal
Route::get('/', [todo::class , 'index'])->middleware('auth');
Route::match(['get', 'post'], '/create', [todo::class , 'add']);
Route::match(['get', 'post'], '/edit/{id}', [todo::class , 'edit']);
Route::get('/del/{id}', [todo::class , 'delete']);

/// Ajax
Route::get('/ajax', [Ajax::class , 'index']);
Route::get('/ajax-data', [Ajax::class , 'AllData']);
Route::post('/ajax-add', [Ajax::class , 'add']);
Route::get('/ajax-data/{id}', [Ajax::class , 'Single_Data']);
Route::get('/ajax-data/del/{id}', [Ajax::class , 'delete']);

// Login normal
Route::match(['get', 'post'], '/login', [Login::class , 'index']);
Route::match(['get', 'post'], '/register', [Login::class , 'register']);

Route::get('/admin', [Login::class , 'admin_home']);
Route::get('/logout', [Login::class , 'logout']);

