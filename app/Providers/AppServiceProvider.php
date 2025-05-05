<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

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
        Schema::defaultStringLength(191);
        
        // Compartir el contador de reservas pendientes con todas las vistas para los administradores
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->isAdmin()) {
                $pendingReservationsCount = Reservation::where('status', 'pending')->count();
                $view->with('pendingReservationsCount', $pendingReservationsCount);
            }
        });
    }
}