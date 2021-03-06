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


Route::get('', [HomeController::class, 'index'])->name('index');

Route::post('arquivo/novo', [ArquivoController::class, 'store']);
Route::get('arquivo/{url}', [ArquivoController::class, 'show']);
Route::get('arquivo/{url}/download', [ArquivoController::class, 'download']);
Route::get('arquivo/{arquivo}/delete', [ArquivoController::class, 'destroy']);
