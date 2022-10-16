<?php

use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PassportAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [PassportAuthController::class, 'index']);
Route::get('/login', [PassportAuthController::class, 'login_view'])->name('login');
Route::post('/login', [PassportAuthController::class, 'login'])->name('web.login');
Route::post('/logout', [PassportAuthController::class, 'logout'])->name('web.logout');
Route::get('/is_log', [PassportAuthController::class, 'is_log'])->name('web.is_log');

Route::get('/facturas', [FacturaController::class, 'index'])->name('web.factura.index');
Route::post('/factura-store', [FacturaController::class, 'store'])->name('web.factura.store');
Route::post('/factura-list', [FacturaController::class, 'list'])->name('web.factura.list');
Route::post('/factura-delete', [FacturaController::class, 'delete'])->name('web.factura.delete');
