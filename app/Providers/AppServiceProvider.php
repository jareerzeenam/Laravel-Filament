<?php

namespace App\Providers;

use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        // Configure the default Create/Edit Action to slide over
        CreateAction::configureUsing(function ($action) {
            return $action->slideOver();
        });
    }
}
