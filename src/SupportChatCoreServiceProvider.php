<?php

namespace Ezead\SupportChatCore;

use Illuminate\Support\ServiceProvider;

class SupportChatCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'support-chat');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/support-chat'),
        ], 'support-chat-assets');
    }
}
