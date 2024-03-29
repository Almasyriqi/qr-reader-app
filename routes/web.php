<?php

use App\Http\Controllers\ScanController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ScanController::class, 'filter'])->name('scan.filter');
Route::get('/code', [ScanController::class, 'code'])->name('scan.code');
Route::get('/getScanData', [ScanController::class, 'getScanData'])->name('getScanData');
Route::resource('scan', ScanController::class);
