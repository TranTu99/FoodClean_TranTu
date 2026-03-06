<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // ✅ Cần import Facade View này để gọi composer()
use Illuminate\Support\ServiceProvider;
use App\Models\Category;            // Import Model Category

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
        View::composer('partials.header', function ($view) {
            try {
                $menuCategories = Category::where('display', 1)->orderBy('stt', 'asc')->get();
                $view->with('menuItems', $menuCategories);
            } catch (\Exception $e) {
                $view->with('menuItems', collect());
            }
        });
    }
}
