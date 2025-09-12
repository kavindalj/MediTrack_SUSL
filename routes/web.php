<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrescriptionController;

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

// Protected dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/categories', [DashboardController::class, 'categories'])->name('dashboard.categories');
    Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products');
    Route::get('/dashboard/prescription', [DashboardController::class, 'prescription'])->name('dashboard.prescription');
    Route::get('/dashboard/prescription/{id}/details', [DashboardController::class, 'getPrescriptionDetails'])->name('dashboard.prescription.details');
    Route::delete('/dashboard/prescription/{id}', [DashboardController::class, 'deletePrescription'])->name('dashboard.prescription.delete');
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

    Route::get('/dashboard/products/add', [DashboardController::class, 'addProduct'])->name('dashboard.products.add');

    Route::get('/dashboard/users/add', [DashboardController::class, 'addUser'])->name('dashboard.users.add');
    Route::post('/dashboard/users/add', [DashboardController::class, 'addUserPost'])->name('dashboard.users.add.post');
    Route::delete('/dashboard/users/{id}', [DashboardController::class, 'deleteUsers'])->name('dashboard.users.delete');

    Route::post('/dashboard/profile/update-password', [DashboardController::class, 'updatePassword'])->name('dashboard.profile.update-password');
    Route::post('/dashboard/profile/update-profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update-profile');

    Route::get('/dashboard/prescription/create', [PrescriptionController::class, 'create'])->name('dashboard.prescription.create');
    Route::post('/dashboard/prescription/store', [PrescriptionController::class, 'store'])->name('dashboard.prescription.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

