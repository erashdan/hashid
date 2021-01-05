<?php

namespace Erashdan\Hashid;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class HashidServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        Validator::extend('hashed_exists',
            HashedIdValidator::class.'@validate',
            trans('The selected :attribute is invalid.')
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function bootForConsole()
    {
        $this->publishes([
            __DIR__.'/../config/hashid.php' => config_path('hashid.php'),
        ], 'config');
    }
}
