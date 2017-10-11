<?php namespace Wongpinter\GoogleClient;

use Illuminate\Support\ServiceProvider;

/**
 * Created By: Sugeng
 * Date: 10/5/17
 * Time: 11:30
 */
class GoogleClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/google.php', 'google');

        $this->app->singleton('google.client', function () {
            return new Client(config('google'));
        });
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/google.php' => config_path('google.php')
        ], 'config');
    }
}