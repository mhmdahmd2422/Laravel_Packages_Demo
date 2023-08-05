<?php

use App\Helpers\ImageFilter;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id}/edit', function ($id){
    return $id;
})->name('user.edit');

Route::get('image', function (){
    $img = Image::make('Laravel-9.jpg')
        ->filter(new ImageFilter(50))
        ->save('laravel-edit.jpg');
    return $img->response();
});

///////////////////////////

Route::get('shop', [\App\Http\Controllers\CartController::class, 'shop'])->name('shop');

Route::get('cart', [\App\Http\Controllers\CartController::class, 'cart'])->name('cart');

Route::get('add-to-cart/{product_id}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('add-to-cart');

Route::get('remove-from-cart/{rowId}', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('remove-from-cart');

Route::get('clear-cart', [\App\Http\Controllers\CartController::class, 'clearCart'])->name('clear-cart');

Route::get('qty-increment/{rowId}', [\App\Http\Controllers\CartController::class, 'qtyIncrement'])->name('qty-increment');

Route::get('qty-decrement/{rowId}', [\App\Http\Controllers\CartController::class, 'qtyDecrement'])->name('qty-decrement');

/////////////////////////////

Route::get('/dashboard', function (\App\DataTables\UsersDataTable $dataTable) {
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
