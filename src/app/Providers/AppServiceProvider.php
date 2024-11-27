<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Define the directory where bindings are located
        $bindingsDirectory = config_path('bindings');

        // Check if the directory exists
        if (File::exists($bindingsDirectory)) {
            // Get all PHP files in the bindings directory
            foreach (File::allFiles($bindingsDirectory) as $file) {
                // Load the file and get the bindings array
                $bindings = require $file->getPathname();

                // Register each interface and implementation binding
                foreach ($bindings as $interface => $implementation) {
                    $this->app->bind($interface, $implementation);
                }
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
