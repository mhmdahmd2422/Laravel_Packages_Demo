<?php

use App\Helpers\ImageFilter;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//////////////////////////////// YAJRA
Route::get('/dashboard', function (\App\DataTables\UsersDataTable $dataTable) {
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('user/{id}/edit', function ($id){
    return $id;
})->name('user.edit');

///////////////////////////////// Intervention

Route::get('image', function (){
    $img = Image::make('Laravel-9.jpg')
        ->filter(new ImageFilter(50))
        ->save('laravel-edit.jpg');
    return $img->response();
});

/////////////////////////// Laravel Carts

Route::get('shop', [\App\Http\Controllers\CartController::class, 'shop'])->name('shop');

Route::get('cart', [\App\Http\Controllers\CartController::class, 'cart'])->name('cart');

Route::get('add-to-cart/{product_id}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('add-to-cart');

Route::get('remove-from-cart/{rowId}', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('remove-from-cart');

Route::get('clear-cart', [\App\Http\Controllers\CartController::class, 'clearCart'])->name('clear-cart');

Route::get('qty-increment/{rowId}', [\App\Http\Controllers\CartController::class, 'qtyIncrement'])->name('qty-increment');

Route::get('qty-decrement/{rowId}', [\App\Http\Controllers\CartController::class, 'qtyDecrement'])->name('qty-decrement');

///////////////////////////// Spatie

Route::get('create-role', function (){
//   $role = Role::create(['name' => 'publisher']);
//
//   return $role;

//    $permission = Permission::create(['name' => 'edit articles']);
//
//    return $permission;

    $user = auth()->user();
//    $user->assignRole('writer');
//    $user->givePermissionTo('delete articles');

//    return $user->getPermissionNames();
//    return $user->getRoleNames();
    $checkPermission = $user->can('delete articles');
    if($checkPermission){
        return 'user have delete articles permission';
    }else{
        return 'user doesnt have delete articles permission';
    }
});

Route::get('posts', function (){
    $posts = \App\Models\Post::all();

    return view('post.post', compact('posts'));
//    auth()->user()->assignRole('admin');
});




require __DIR__.'/auth.php';
