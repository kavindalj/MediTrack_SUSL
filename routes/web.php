<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [AuthController::class ,'login'])->name('login');
Route::post('/', [AuthController::class ,'loginPost'])->name('login.post');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/categories', [DashboardController::class, 'categories'])->name('dashboard.categories');
Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products');
Route::get('/dashboard/sale', [DashboardController::class, 'sale'])->name('dashboard.sale');
Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

Route::get('/dashboard/products/add', [DashboardController::class, 'addProduct'])->name('dashboard.products.add');

Route::get('/dashboard/users/add', [DashboardController::class, 'addUser'])->name('dashboard.users.add');
Route::post('/dashboard/users/add', [DashboardController::class, 'addUserPost'])->name('dashboard.users.add.post');

Route::get('/dashboard/sale/create', [DashboardController::class, 'createSale'])->name('dashboard.sale.create');

