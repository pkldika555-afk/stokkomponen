<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterController;
use App\Models\MasterKomponen;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('komponen', MasterController::class);   
Route::resource('departemen', DepartemenController::class);   

Route::get('/laporan/transaksi', [LaporanController::class, 'index'])->name('laporan.transaksi');