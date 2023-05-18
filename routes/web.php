<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ManualDrawController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\VerifierAuth;
use App\Http\Livewire\Draw\Slot;
use App\Http\Livewire\Users;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Route::get('slot', Slot::class);
});

Route::controller(DashboardController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->name('dashboard.')->prefix(DashboardController::BASE)->group(function () {
    Route::get('/', 'index');
    Route::get('/ajax-online-winners', 'ajaxOnlineWinners')->name('ajax-online-winners');
});

Route::controller(ManualDrawController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AdminAuth::class
])->name('manual-draw.')->prefix(ManualDrawController::BASE)->group(function () {
    Route::get('/', 'index');
    Route::get('/ajax-tambiolo-winners', 'ajaxTambioloWinners')->name('ajax-tambiolo-winners');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
});

Route::controller(VerifyController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    VerifierAuth::class
])->name('verify.')->prefix(VerifyController::BASE)->group(function () {
    Route::get('/', 'index');
});

Route::controller(UsersController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AdminAuth::class
])->name('users.')->prefix(UsersController::BASE)->group(function () {
    Route::get('/', 'index');
});

Route::controller(DrawController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AdminAuth::class
])->name('draw.')->prefix(DrawController::BASE)->group(function () {
    Route::get('/', 'index');
});
