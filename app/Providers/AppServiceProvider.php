<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Always ensure super-admin has all permissions
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole) {
            $allPermissions = Permission::all();
            $superAdminRole->syncPermissions($allPermissions);
        }
    }
}
