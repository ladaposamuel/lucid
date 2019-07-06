<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Document;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Document', function () {
            return new Document;
        });
    }
}
