<?php

namespace aharen\Language;

use Illuminate\Support\ServiceProvider;
use Language;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '../../migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!\App::runningInConsole()) {
            $language_segment = \Request::segment(1);
            Language::validate($language_segment);
        }
    }
}
