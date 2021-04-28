<?php

use App\Http\Controllers\ListPantries;
use Illuminate\Foundation\Application;
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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function() {
    return Inertia::render('Home');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/pantries/create', [ListPantries::class, 'create'])->name('pantries.create');
    Route::post('/pantries/store', [ListPantries::class, 'store'])->name('pantries.store');
    Route::get('/pantries/edit/{id}', [ListPantries::class, 'edit'])->name('pantries.edit');
    Route::put('/pantries/update', [ListPantries::class, 'update'])->name('pantries.update');
});

Route::get('/pantries', [ListPantries::class, 'index'])->name('pantries.index');
Route::get('/pantries/show/{id}', [ListPantries::class, 'show'])->name('pantries.show');

require __DIR__.'/auth.php';
