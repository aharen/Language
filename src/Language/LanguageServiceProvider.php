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
        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations'),
            __DIR__ . '/../../seeds/' => base_path('/database/seeds'),
        ]);
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
