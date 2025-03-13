<?php


// dashboard routes

use App\Models\BankBalance;
use App\Models\RevolvingBalanceBill;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\StockController;
use App\Http\Controllers\Dashboard\FlavorController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SubSaleController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\Dashboard\BankBalanceController;
use App\Http\Controllers\Dashboard\QuantityTypeController;
use App\Http\Controllers\Dashboard\TotalBalanceController;
use App\Http\Controllers\Dashboard\FinancialDiaryController;
use App\Http\Controllers\Dashboard\PreviousBalanceController;
use App\Http\Controllers\Dashboard\RevolvingBalanceBillController;

Route::group([
    'prefix' => '',
    'middleware' => ['auth'],
    'as' => 'dashboard.'
], function () {
    /* ********************************************************** */

    // Dashboard ************************
    Route::get('/', function () {return view('dashboard.index');})->name('home');

    // Logs ************************
    Route::get('logs',[ActivityLogController::class,'index'])->name('logs.index');
    Route::get('getLogs',[ActivityLogController::class,'getLogs'])->name('logs.getLogs');

    // Users ************************
    Route::get('profile/settings',[UserController::class,'settings'])->name('profile.settings');

    /* ********************************************************** */
    // Products ************************
    Route::get('products/search',[ProductController::class,'search'])->name('products.search');

    // Financial Diaries ************************
    Route::post('financialdiaries/{date}/dailyMal',[FinancialDiaryController::class,'dailyMal'])->name('financialdiaries.dailyMal');


    /* ********************************************************** */

    // Resources
    Route::resource('constants', ConstantController::class)->only(['index','store','destroy']);
    Route::resource('currencies', CurrencyController::class)->except(['show','edit','create']);

    Route::resources([
        'users' => UserController::class,
        'suppliers' => SupplierController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'flavors' => FlavorController::class,
        'sizes' => SizeController::class,
        'quantitytypes' => QuantityTypeController::class,
        'stocks' => StockController::class,
        'invoices' => InvoiceController::class,
        'financialdiaries' =>FinancialDiaryController::class,
        'bankbalances' =>BankBalanceController::class,
        'previousbalances' =>PreviousBalanceController::class,
        'revolvingbalancebills' =>RevolvingBalanceBillController::class,
        'subsales' =>SubSaleController::class,
        'totalbalances' =>TotalBalanceController::class,
    ]);
    /* ********************************************************** */
});
