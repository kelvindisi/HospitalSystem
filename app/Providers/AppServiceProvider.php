<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\Role;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function() {
            return auth()->check() && $this->checkRole('admin');
        });
        Blade::if('doctor', function() {
            return auth()->check() && $this->checkRole('doctor');
        });
        Blade::if('pharmacy', function() {
            return auth()->check() && $this->checkRole('pharmacy');
        });
        Blade::if('finance', function() {
            return auth()->check() && $this->checkRole('finance');
        });
        Blade::if('laboratory', function() {
            return auth()->check() && $this->checkRole('laboratory');
        });
        Blade::if('receptionist', function() {
            return auth()->check() && $this->checkRole('receptionist');
        });
        Blade::if('noadmin', function() {
            return $this->checkIfAdminExists();
        });
        
        
    }

    private function checkIfAdminExists()
    {
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole)
        {
            if ($adminRole->users->count() > 0)
                return false;
        }

        return true;

    }

    private function checkRole($role)
    {
        
        return auth()->user()->roles->first()->name == $role;
    }
}
