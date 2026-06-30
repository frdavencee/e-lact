<?php

namespace App\Providers;

use App\Models\Personel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Bind {waspang} route parameter to Personel model
        Route::model('waspang', Personel::class);
    }
}
