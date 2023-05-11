<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifyController;
use App\Http\Livewire\Draw\Slot;

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
    Route::get('/', function () {
        return view('dashboard');
    })->name('home');

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
});

Route::controller(VerifyController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->name('verify.')->prefix(VerifyController::BASE)->group(function () {
    Route::get('/', 'index');
});

Route::controller(DrawController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->name('draw.')->prefix(DrawController::BASE)->group(function () {
    Route::get('/', 'index');
    Route::get('/ajax_source_winners', 'source_winners')->name('source_winners');
    Route::get('/success', 'success')->name('success');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');

    Route::get('/edit/{Portal?}', 'edit')->name('edit');
    Route::post('/update', 'update')->name('update');

    Route::get('/delete/{Portal?}', 'delete')->name('delete');
    Route::post('/destroy', 'destroy')->name('destroy');
    Route::get('/{Portal?}', 'show')->name('show');
});
