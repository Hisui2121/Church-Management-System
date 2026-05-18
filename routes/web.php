<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('login');
});

Route::get('/register/account', [RegisterController::class, 'accountForm']);
Route::post('/register/account', [RegisterController::class, 'saveAccount']);

Route::get('/register/personal', [RegisterController::class, 'personalForm']);
Route::post('/register/personal', [RegisterController::class, 'savePersonal']);

Route::get('/register/review',[RegisterController::class, 'review']);
Route::post('/register/submit', [RegisterController::class, 'submit']);

Route::get('/login', function(){
    return view ('login');
});

Route::get('/hello', [HelloController::class, 'index']);
