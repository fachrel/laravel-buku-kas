<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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

Route::get('/test', [TransactionController::class, 'testExport'])->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// })->middleware('auth');

Route::resource('users', UserController::class)->middleware(['auth', 'role:admin']);
Route::put('users/{id}', [UserController::class, 'updateData'])->middleware(['auth', 'role:admin']);

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware('auth');
// Route::resource('trasaction', TransactionController::class)->middleware('auth');
Route::get('transactions', [TransactionController::class, 'showTransaksi'])->middleware('auth');
Route::delete('transactions/{id}', [TransactionController::class, 'destroy'])->middleware('auth');

Route::get('transactions/pengeluaran', [TransactionController::class, 'showPengeluaran'])->middleware('auth');
Route::post('transactions/export', [TransactionController::class, 'export'])->middleware('auth');
Route::post('transactions', [TransactionController::class, 'store'])->middleware('auth');


Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
