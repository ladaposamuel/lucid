<?php

namespace Lucid\Providers;

use Illuminate\Support\ServiceProvider;
use Lucid\Core\Document;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Document', function () {
            return new Document;
        });
    }
}
