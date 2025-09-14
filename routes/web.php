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

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/dashboard/products', [DashboardController::class, 'products'])->name('dashboard.products')->middleware('auth');
Route::get('/dashboard/prescription', [DashboardController::class, 'prescription'])->name('dashboard.prescription')->middleware('auth');
Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users')->middleware('auth');
Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile')->middleware('auth');

// Product routes
Route::get('/dashboard/products/add', [ProductController::class, 'addProduct'])->name('dashboard.products.add')->middleware('auth');
Route::post('/dashboard/products/store', [ProductController::class, 'storeProduct'])->name('dashboard.products.store')->middleware('auth');
Route::delete('/dashboard/products/{id}', [ProductController::class, 'deleteProduct'])->name('dashboard.products.delete')->middleware('auth');

// User routes
Route::get('/dashboard/users/add', [UserController::class, 'addUser'])->name('dashboard.users.add')->middleware('auth');
Route::post('/dashboard/users/add', [UserController::class, 'addUserPost'])->name('dashboard.users.add.post')->middleware('auth');
Route::post('/dashboard/users/verify-password', [UserController::class, 'verifyPassword'])->name('dashboard.users.verify-password')->middleware('auth');
Route::get('/dashboard/users/{id}', [UserController::class, 'getUser'])->name('dashboard.users.get')->middleware('auth');
Route::patch('/dashboard/users/{id}', [UserController::class, 'updateUser'])->name('dashboard.users.update')->middleware('auth');
Route::delete('/dashboard/users/{id}', [UserController::class, 'deleteUsers'])->name('dashboard.users.delete')->middleware('auth');

// Profile routes
Route::post('/dashboard/profile/update-password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.update-password')->middleware('auth');
Route::post('/dashboard/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('dashboard.profile.update-profile')->middleware('auth');

// Prescription routes
Route::get('/dashboard/prescription/create', [PrescriptionController::class, 'create'])->name('dashboard.prescription.create')->middleware('auth');
Route::post('/dashboard/prescription/store', [PrescriptionController::class, 'store'])->name('dashboard.prescription.store')->middleware('auth');
Route::get('/dashboard/prescription/{id}/details', [PrescriptionController::class, 'getPrescriptionDetails'])->name('dashboard.prescription.details')->middleware('auth');
Route::delete('/dashboard/prescription/{id}', [PrescriptionController::class, 'deletePrescription'])->name('dashboard.prescription.delete')->middleware('auth');

// Auth routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

