<?php

namespace ChaosWs\LaravelChaosBroadcaster;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Pusher\Pusher;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(BroadcastManager $broadcastManager)
    {
        $broadcastManager->extend('chaos', function (Application $app, array $config) {

            return new Broadcaster(
                new Pusher(
                    $config['key'], $config['secret'],
                    $config['app_id'], $config['options'] ?? []
                ),
                $this->app->make('redis'), 
                $config['connection'] ?? null
            );
        });
    }
}
