<?php

namespace Ezead\SupportChatCore;

use Illuminate\Support\ServiceProvider;

class SupportChatCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/support-chat.php', 'support-chat');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/support-chat.php' => config_path('support-chat.php'),
        ], 'support-chat-core-config');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'support-chat');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/support-chat'),
        ], 'support-chat-assets');
    }
}
