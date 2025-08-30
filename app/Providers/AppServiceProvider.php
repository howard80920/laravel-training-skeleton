<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;

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
        if (!$this->app->runningInConsole()) {
            // 非本機開發，強制https
            if (!$this->app->environment([ 'local' ])) {
                URL::forceScheme('https');
            }
        }

        if (config('app.debug')) {
            // 記錄query
            DB::listen(function (QueryExecuted $query) {
                logger()
                ->channel('querylog')
                ->debug("{$query->time} ms >> [{$query->connectionName}] {$query->sql}", $query->bindings);
            });
        }
        // 記錄query時間過長
        DB::whenQueryingForLongerThan(600, function (Connection $connection, QueryExecuted $event) {
            logger()
            ->channel('slowlog')
            ->warning("{$event->time} ms >> [{$event->connectionName}] {$event->sql}", $event->bindings);
        });
    }
}
