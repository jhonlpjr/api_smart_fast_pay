<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
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
        $this->loadMigrationsFrom([
            base_path('app/modules/user/infraestructure/database/migrations'),
            base_path('app/modules/payment/infraestructure/database/migrations'),
            base_path('app/modules/paymentmethod/infraestructure/database/migrations'),
        ]);
    }
}
