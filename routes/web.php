<?php
    
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\EmployeeController;
    use App\Http\Controllers\BakeryItemController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\CustomerController; // Corrected inclusion
    use App\Http\Controllers\CompletedOrderController; // Corrected inclusion
    
    
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
    
    require __DIR__ . '/auth.php';
    
    
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::resource('customers', CustomerController::class);
    
    
        // Bakery items full CRUD
        Route::resource('items', BakeryItemController::class);
    
        // Show the cart contents
        Route::get('/cart', [CartController::class, 'index'])
            ->name('cart.index');
    
        // Cart: add an item
        Route::post('/cart/add/{item}', [CartController::class, 'store'])
            ->name('cart.add');
    
    
        // remove from cart
        Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
    
        Route::patch('/cart/{item}', [CartController::class, 'update'])
            ->name('cart.update');
        // … your existing /items and /cart routes …
    
        // CRUD routes for orders:
        Route::resource('orders', OrderController::class)->only([
            'create', 'store', 'show', 'destroy', 'index', 'edit', 'update'
        ]);
        
        Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
        // CRUD routes for employees:
        Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create'); // For the form
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');       // To store the new employee
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit'); //edit form
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    
        // CRUD routes for completed orders:
        Route::resource('completed_orders', CompletedOrderController::class);
    });

