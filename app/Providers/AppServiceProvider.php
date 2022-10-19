<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());


        DB::whenQueryingForLongerThan(500, function (Connection $connection) {
            logger()
                ->channel('telegram')
                ->debug('whenQueryingForLongerThan: ' . $connection->query()->toSql());
        });
        if (app()->isProduction()) {

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::second(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
                }
            );
        }
    }
}
