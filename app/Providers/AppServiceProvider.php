<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceRootUrl(env('APP_URL'));
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        // @t('text') directive — translates when locale is 'en', no-op in 'id'
        Blade::directive('t', function (string $expression): string {
            return "<?php echo t({$expression}); ?>";
        });
    }
}
