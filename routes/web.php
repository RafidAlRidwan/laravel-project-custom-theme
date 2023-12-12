<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrative\AuthController;
use App\Http\Controllers\Administrative\HomeController;

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

Auth::routes();

Route::namespace('Administrative')->middleware('guest')->group(function () {

  Route::get('/', [AuthController::class, 'index'])->name('login');

  Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

});

Route::namespace('Administrative')->middleware('auth')->prefix('administrative')->name('administrative.')->group(function () {

  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

  // Role
  Route::prefix('role')->group(function () {

    Route::get('/list', [RoleController::class, 'index'])->name('role');

    Route::get('role-data', [RoleController::class, 'data'])->name('role.data');

    Route::get('create', [RoleController::class, 'create'])->name('role.create');

    Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role.edit');

    Route::put('update/{id}', [RoleController::class, 'update'])->name('role.update');

    Route::post('create', [RoleController::class, 'store'])->name('role.store');

    Route::delete('delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
  });

  // Permission
  Route::prefix('permission')->group(function () {

    Route::get('/list', [PermissionController::class, 'index'])->name('permission');

    Route::get('permission-data', [PermissionController::class, 'data'])->name('permission.data');

    Route::get('create', [PermissionController::class, 'create'])->name('permission.create');

    Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');

    Route::put('update/{id}', [PermissionController::class, 'update'])->name('permission.update');

    Route::post('create', [PermissionController::class, 'store'])->name('permission.store');

    Route::delete('delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
  });

  // User
  Route::prefix('user')->group(function () {

    Route::get('/list', [UserController::class, 'index'])->name('user');

    Route::get('user-data', [UserController::class, 'data'])->name('user.data');

    Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');

    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
  });
});
