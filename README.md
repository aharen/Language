# Language
Multi language for Laravel 5.3+

---

## Installations

`composer require aharen/language`

## Configuration

Add the service provider to `providers` array in `config/app.php`

`aharen\Language\LanguageServiceProvider::class,`

Add the facade to `aliases` array in `config/app.php`

`'Language' => 'aharen\Language\Facades\Language::class',`

Run `vendor:publish` artisan command to publish the database migration file and the default seeder

`php artisan vendor:publish`

Now add the `DefaultLanguageSeeder` to `database/DatabaseSeeder.php`

`$this->call(DefaultLanguageSeeder::class);`

You might need to run `composer dumpautoload` for the seeder to start working 

**Optional** The provided seeder will create English as the default language but you can change the seeder to any language you like. 

In addition you will have to update `locale` and `fallback_locale` in `config/app.php` to your desired default language, since the package uses these to maintain set locale and default locale.

This will enable the use of Laravels default localization methods and directives such as 'echo trans('messages.welcome');` and `@lang('messages.welcome')`. You can store your translations in the default `resources/lang` directory.

## Setup

You should add a route prefix to your routes in one of the following ways:

1. In your routes file to the route group

        Route::group(['prefix' => \App::getLocale()], function () {
          // your routes here
        });

2. Or you can modify `mapWebRoutes()` method in `App\RouteServiceProvider` as follows:

        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
            'prefix'     => \App::getLocale(),
        ], function ($router) {
            require base_path('routes/web.php');
        }); 
        







