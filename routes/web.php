<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OngkirController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [OngkirController::class, 'index']);
Route::post('/cek_biaya', [OngkirController::class, 'cekBiaya']);
Route::post('/get_city', [OngkirController::class, 'getCity']);


