<?php

use App\Http\Controllers\PostController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    //Route::resource('posts', PostController::class);
    //Route::get('posts/trashed',[PostController::class,'trashed'])->name('posts.trashed');
});

Route::group(["prefix"=>"posts","middleware"=>"auth"],function(){
    Route::get('/',[PostController::class,'index'])->name('posts.index');
    Route::get('create',[PostController::class,'create'])->name('posts.create');
    Route::post('store',[PostController::class,'store'])->name('posts.store');
    Route::get('{post}/edit',[PostController::class,'edit'])->name('posts.edit');
    Route::put('{post}/update',[PostController::class,'update'])->name('posts.update');
    Route::delete('{post}/destroy',[PostController::class,'destroy'])->name('posts.destroy');
    Route::get('{post}/restore',[PostController::class,'restore'])->name('posts.restore');
    Route::delete('{post}/force-destroy',[PostController::class,'forceDestroy'])->name('posts.force-destroy');
    Route::get('trashed',[PostController::class,'trashed'])->name('posts.trashed');
    Route::delete('/posts/{id}/forceDelete', [PostController::class,'forceDelete'])->name('posts.force_delete');
    Route::get('show/{id}',[PostController::class,'show'])->name('posts.show');
})->middleware('auth');



//Route::get('posts/test',[PostController::class,'test'])->name('posts.test');

require __DIR__.'/auth.php';
