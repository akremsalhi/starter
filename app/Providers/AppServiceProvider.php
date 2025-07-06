<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
        $this->configureModels();

        $this->configureDatabase();

        $this->configureDates();
    }

    private function configureModels(): void
    {
        Model::shouldBeStrict(! app()->isProduction());

        Model::automaticallyEagerLoadRelationships();
    }

    private function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    private function configureDates(): void
    {
        Date::useClass(CarbonImmutable::class);
    }
}
