<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

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

Route::get('/products', [ShopController::class, 'getProducts'])->name('get.products');
Route::get('/product/{id}', [ShopController::class, 'getProductById'])->name('get.product.by.id');
Route::get('/search/{slug}', [ShopController::class, 'getProductSearch'])->name('get.product.search');
Route::get('/searching/bycategory/{cat_id}/{slug}', [ShopController::class, 'getProductSearchByCategories'])->name('get.product.search.by.categories');


Route::get('/categories', [ShopController::class, 'getCategories'])->name('get.categories');
Route::get('/category/{id}', [ShopController::class, 'getCategoryById'])->name('get.category.by.id');


Route::get('/check/products', [ShopController::class, 'getApiResult'])->name('get.check.products');
