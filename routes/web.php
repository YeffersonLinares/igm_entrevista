<?php

use App\Http\Controllers\FacturaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//dsdsd

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

Route::get('/', [FacturaController::class, 'index']);
Route::post('/factura-store', [FacturaController::class, 'store'])->name('web.factura.store');
Route::post('/factura-list', [FacturaController::class, 'list'])->name('web.factura.list');
Route::post('/factura-delete', [FacturaController::class, 'delete'])->name('web.factura.delete');
// Route::get('/factura-store', [FacturaController::class, 'store'])->name('web.factura.store');

// Route::get('/', function () {
//     return Inertia::render('Factura');
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
