<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

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

// All authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products');
    Route::get('/dashboard/prescription', [DashboardController::class, 'prescription'])->name('dashboard.prescription');
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

    // Product routes
    Route::get('/dashboard/products/add', [ProductController::class, 'addProduct'])->name('dashboard.products.add');
    Route::post('/dashboard/products/store', [ProductController::class, 'storeProduct'])->name('dashboard.products.store');
    Route::delete('/dashboard/products/{id}', [ProductController::class, 'deleteProduct'])->name('dashboard.products.delete');

    // User routes
    Route::get('/dashboard/users/add', [UserController::class, 'addUser'])->name('dashboard.users.add');
    Route::post('/dashboard/users/add', [UserController::class, 'addUserPost'])->name('dashboard.users.add.post');
    Route::post('/dashboard/users/verify-password', [UserController::class, 'verifyPassword'])->name('dashboard.users.verify-password');
    Route::get('/dashboard/users/{id}', [UserController::class, 'getUser'])->name('dashboard.users.get');
    Route::patch('/dashboard/users/{id}', [UserController::class, 'updateUser'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/{id}', [UserController::class, 'deleteUsers'])->name('dashboard.users.delete');

    // Profile routes
    Route::post('/dashboard/profile/update-password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.update-password');
    Route::post('/dashboard/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('dashboard.profile.update-profile');

    // Prescription routes
    Route::get('/dashboard/prescription/create', [PrescriptionController::class, 'create'])->name('dashboard.prescription.create');
    Route::post('/dashboard/prescription/store', [PrescriptionController::class, 'store'])->name('dashboard.prescription.store');
    Route::get('/dashboard/prescription/{id}/details', [PrescriptionController::class, 'getPrescriptionDetails'])->name('dashboard.prescription.details');
    Route::delete('/dashboard/prescription/{id}', [PrescriptionController::class, 'deletePrescription'])->name('dashboard.prescription.delete');

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

