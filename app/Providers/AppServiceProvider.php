<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        $this->registerGates();
    }

    private function registerGates(): void
    {
        \Illuminate\Support\Facades\Gate::define('admin', function (\App\Models\User $user) {
            return $user->isAdmin();
        });
    }
}
