<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/')->controller(HomeController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('home.index');
    });

//clients route
    Route::prefix('/clients')->controller(ClientController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('clients.index');

        //store
        Route::post('/store', 'store')->name('clients.store');

        //update
        Route::put('/update/{id}', 'update')->name('clients.update');

        //show
        Route::get('/show/{client}', 'show')->name('clients.show');

        //delete
        Route::delete('/delete/{client}', 'delete')->name('clients.delete');
    });

//providers route
    Route::prefix('/providers')->controller(ProviderController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('providers.index');

        //store
        Route::post('/store', 'store')->name('providers.store');

        //update
        Route::put('/update/{id}', 'update')->name('providers.update');

        //show
        Route::get('/show/{provider}', 'show')->name('providers.show');

        //delete
        Route::delete('/delete/{provider}', 'delete')->name('providers.delete');
    });

//stocks route
    Route::prefix('/stocks')->controller(StockController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('stocks.index');

        //create
        Route::get('/create', 'create')->name('stocks.create');

        //store
        Route::post('/store', 'store')->name('stocks.store');

        //show
        Route::get('/show/{stock}', 'show')->name('stocks.show');

        //stock edit
        Route::get('/edit/{stock}', 'edit')->name('stocks.edit');

        //update
        Route::put('/update/{stock}', 'update')->name('stocks.update');

        //delete
        Route::delete('/delete/{stock}', 'destroy')->name('stocks.destroy');

    });

//format route
    Route::prefix('/formats')->controller(FormatController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('formats.index');

        //store
        Route::post('/store', 'store')->name('formats.store');

        //update
        Route::put('/update/{format}', 'update')->name('formats.update');

        //delete
        Route::delete('/delete/{format}', 'destroy')->name('formats.destroy');
    });

//type route
    Route::prefix('/types')->controller(TypeController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('types.index');

        //store
        Route::post('/store', 'store')->name('types.store');

        //update
        Route::put('/update/{id}', 'update')->name('types.update');

        //destroy
        Route::delete('/delete/{id}', 'destroy')->name('types.destroy');
    });

//stocks route
    Route::prefix('/stocks-movement')->controller(StockMovementController::class)->group(function () {
        //index
        Route::get('/{_stock}', 'index')->name('stocks-movement.index');

        //store
        Route::post('/store', 'store')->name('stock-movements.store');

        //destory
        Route::delete('/delete/{movement}', 'destroy')->name('stock-movements.destroy');
    });

//services route
    Route::prefix('/service')->controller(ServiceController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('services.index');

        //store
        Route::post('/store', 'store')->name('services.store');

        //update
        Route::put('/update/{service}', 'update')->name('services.update');

        //destroy
        Route::delete('/delete/{service}', 'destroy')->name('services.destroy');

        //service
        Route::get('/show/{service}', 'show')->name('services.show');
    });

//category route
    Route::prefix('/categories')->controller(CategoryController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('categories.index');

        //store
        Route::post('/store', 'store')->name('categories.store');

        //update
        Route::put('/update/{category}', 'update')->name('categories.update');

        //delete
        Route::delete('/delete/{category}', 'destroy')->name('categories.destroy');
    });

//activity route
    Route::prefix('/activities')->controller(ActivityController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('activities.index');

        //create
        Route::get('/create', 'create')->name('activities.create');

        //show
        Route::get('/show/{activity}', 'show')->name('activities.show');

        //print
        Route::get('/print/{activity}', 'print')->name('activities.print');
    });

//préférences
    Route::prefix('/preferences')->controller(PreferenceController::class)->group(function () {
        //about
        Route::get('/about', 'about')->name('preferences.about');
    });

//bilan
    Route::prefix('/bilan')->controller(BilanController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('bilan.index');
    });

//expenses controller
    Route::prefix('/expenses')->controller(ExpensesController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('expenses');

        //new ewpense
        Route::post('/new_expense', 'new_expense')->name('new_expense');

        //destroy expense
        Route::delete('/delete/{expense}', 'expense_destroy')->name('expense_destroy');

        //modifier
        Route::put('/update/{expense}', 'update_expense')->name('update_expense');
    });
});
