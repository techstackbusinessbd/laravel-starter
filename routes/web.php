<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    //User Management
    Route::middleware('role:Super Admin,Admin')->group(function(){
        //User Route
        Route::resource('users', UserController::class);
        // Status
        Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    });

    //Role Management
    Route::middleware('role:Super Admin,Admin,Salesman')->group(function(){
        //User Route
        Route::resource('roles', RoleController::class);
        // Status
        Route::patch('/roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggleStatus');
        // `web.php` রাউট ফাইলের মধ্যে
        Route::get('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
        Route::post('roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('roles.permissions.sync');
        Route::delete('roles/{role}/permissions/{permission}', [RoleController::class, 'removePermission'])->name('roles.permissions.remove');


    });

    //Permission Management
    Route::middleware('role:Super Admin,Admin,Salesman')->group(function(){
        //User Route
        Route::resource('permissions', PermissionController::class);
    });

});
