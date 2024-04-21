<?php
use Illuminate\Support\Facades\Route;

// Import the necessary controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopkeeperController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Shopkeeper;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;

// Home route
Route::get('/', function () {
    return view('welcome');
});
// Authentication routes
Route::post('dashboard', function () {


    // Attempt user authentication
    $credentials = request(['email', 'password', 'remember']);
    // Validate the form data
    request()->validate([
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string'],
        'remember' => ['nullable'],
    ]);

    if (Auth::attempt($credentials)) {
        // Authentication successful

        // Redirect to the appropriate page
        return redirect()->intended('/dashboard');
    } else {
        // Authentication failed

        // Redirect back to the login page with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
});

// Protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        $today = Carbon::today();

        if ($role == 1) {
            $todayOrdersCount = App\Models\Order::whereDate('created_at', $today)->count();
            $totalShopkeepers = Shopkeeper::count();
            $totalCategories = Category::count();
            $totalProducts = Product::count();
            $totalCustomers= null;
        } else {
            $shopId = auth()->user()->shop_id;
            $customerIds = App\Models\Customer::where('shop_id', $shopId)->pluck('id');
            $todayOrdersCount = App\Models\Order::whereDate('created_at', $today)
                ->whereIn('customer_id', $customerIds)
                ->count();
            $totalCustomers = Customer::where('shop_id', $shopId)->count();
            $totalShopkeepers = null;
            $totalCategories = App\Models\Category::where('shop_id', $shopId)->count();
            $totalProducts = App\Models\Product::where('shop_id', $shopId)->count();
        }

        return view('dashboard', compact('role', 'todayOrdersCount', 'totalShopkeepers', 'totalCategories', 'totalProducts', 'totalCustomers'));

    })->name('dashboard');






    // Categories routes
    Route::resource('categories', CategoryController::class);

    // Categories routes

    Route::resource('order', OrderController::class);
    Route::get('order', [OrderController::class, 'index']);
    Route::get('order/print/{id}', [OrderController::class, 'print'])->name('order.print');
    Route::get('/orders/filter', [OrderController::class, 'showOrdersByDateRange']);

    Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
    // Shopkeepers routes
    Route::resource('shopkeepers', ShopkeeperController::class);

    // Products routes
    Route::resource('products', ProductController::class);

    //customer routes
    Route::resource('customer', CustomerController::class);

});

    Route::post('/product', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/category', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/show', function () {
        return view('show');
    });

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
