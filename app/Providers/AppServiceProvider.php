<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('components.topbar', function ($view) {
            $recentMatches = \App\Models\Match_::with(['equipeA', 'equipeB', 'discipline'])
                ->where('statut', 'joue')
                ->orderBy('date_match', 'desc')
                ->take(5)
                ->get();
            $view->with('recentMatches', $recentMatches);
        });
    }
}
