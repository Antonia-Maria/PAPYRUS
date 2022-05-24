<?php

use Illuminate\Support\Facades\Route;
use app\http\controllers\DosareController;
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

Route::get('AdaugaDosar', function () {
    return view('AdaugaDosar');
});
Route::post('submit', 'AdaugaDosarController@save');
Route::post('incercare', 'VizualizareDosarController@show');
