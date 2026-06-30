<?php

namespace App\Providers;

use App\Models\GenerateLog;
use App\Models\Personel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Bind {waspang} → Personel (class name mismatch with route param)
        Route::model('waspang', Personel::class);

        // Bind {document} → GenerateLog (class name mismatch with route param)
        Route::model('document', GenerateLog::class);
    }
}
