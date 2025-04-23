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
    Route::resource('customers', CustomerController::class);
});

use App\Http\Controllers\BakeryItemController;
use App\Http\Controllers\CartController;

Route::middleware('auth')->group(function(){
        // Bakery items full CRUD (we'll only expose index/create/store/show for now)

    Route::resource('items', BakeryItemController::class)
        ->only(['index','create','store','show']);

    // Show the cart contents
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');
        
    // Cart: add an item
    Route::post('/cart/add/{item}', [CartController::class, 'store'])
         ->name('cart.add');


    // … your existing /items and /cart routes …

// CRUD routes for orders:
    Route::resource('orders', \App\Http\Controllers\OrderController::class);

// CRUD routes for employees:
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);

// CRUD routes for completed orders:
    Route::resource('completed_orders', \App\Http\Controllers\CompletedOrderController::class);
     
});




