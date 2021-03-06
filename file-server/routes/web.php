<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\HomeController;
use App\Models\Arquivo;
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


Route::get('', [HomeController::class, 'index']);
Route::get('create', [HomeController::class, 'create']);


Route::post('arquivo/novo', [ArquivoController::class, 'store']);


Route::get('arquivo/{url}', function($url) {
    return Arquivo::where('url', $url)->first();
} );


Route::resource('arquivo', ArquivoController::class);