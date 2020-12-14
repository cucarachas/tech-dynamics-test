<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController as ApiController;

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

Route::get('/intensity', [ApiController::class, 'index'])->name('intensity');
Route::get('/intensity/today', [ApiController::class, 'today'])->name('today');
Route::get('/intensity/date/', [ApiController::class, 'date'])->name('date');
Route::get('/intensity/factors', [ApiController::class, 'factors'])->name('factors');
//more
Route::get('/more', [ApiController::class, 'more'])->name('more');

//ajax
Route::post('/filtering', [ApiController::class, 'filtering'])->name('filtering');
Route::post('/average', [ApiController::class, 'average'])->name('average');


