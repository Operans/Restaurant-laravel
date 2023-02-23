<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\Frontend\WelcomeController::class,'index']);
Route::get('/categories', [\App\Http\Controllers\Frontend\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [\App\Http\Controllers\Frontend\CategoryController::class, 'show'])->name('categories.show');
Route::get('/menus', [\App\Http\Controllers\Frontend\MenuController::class, 'index'])->name('menus.index');
Route::get('/reservation/step-one', [\App\Http\Controllers\Frontend\ReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/step-one', [\App\Http\Controllers\Frontend\ReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [\App\Http\Controllers\Frontend\ReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/step-two', [\App\Http\Controllers\Frontend\ReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou',[\App\Http\Controllers\Frontend\WelcomeController::class, 'thankyou'])->name('thankyou');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','admin']) -> name('admin.')->prefix('admin')->group(function (){
    Route::get('/',[\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/menus', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('/tables', \App\Http\Controllers\Admin\TableController::class);
    Route::resource('/reservation', \App\Http\Controllers\Admin\ReservationController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
