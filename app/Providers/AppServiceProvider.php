<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LogoutResponse;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    public function boot()
    {
        //
    }
}
