<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

use App\Http\Controllers\CustomerController;

Route::middleware(['auth'])->group(function(){
    Route::get('/customers',        [CustomerController::class,'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class,'create'])->name('customers.create');
    Route::post('/customers',       [CustomerController::class,'store'])->name('customers.store');
});



