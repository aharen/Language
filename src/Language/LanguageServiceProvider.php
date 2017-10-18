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
            __DIR__ . '/../../seeds/'      => base_path('/database/seeds'),
            __DIR__ . '/../../config/'     => base_path('/config'),
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
            if ($language_segment === null) {
                $locale = (Language::getLocaleCode() === null) ? config('app.locale') : Language::getLocaleCode();

                return redirect($locale)->send();
            }
            Language::validate($language_segment);
        }
    }
}
