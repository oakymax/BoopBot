<?php

namespace App\Botflow;

use App\Botflow\Console\BotCommand;
use App\Botflow\Console\BotSetup;
use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramActionTime;
use App\Botflow\Events\TelegramCommandReceived;
use App\Botflow\Events\TelegramMessageReceived;
use App\Botflow\Events\TelegramMiddlewareTime;
use App\Botflow\Events\TelegramUpdateReceived;
use App\Botflow\Listeners\TelegramActionTimeListener;
use App\Botflow\Listeners\TelegramCommandListener;
use App\Botflow\Listeners\TelegramMessageListener;
use App\Botflow\Listeners\TelegramMiddlewareTimeListener;
use App\Botflow\Listeners\TelegramUpdateListener;
use App\Botflow\Telegraph\BotflowTelegraph;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class BotflowServiceProvider extends EventServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TelegramMessageReceived::class => [
            TelegramMessageListener::class,
        ],
        TelegramCommandReceived::class => [
            TelegramCommandListener::class,
        ],
        TelegramActionTime::class => [
            TelegramActionTimeListener::class,
        ],
        TelegramMiddlewareTime::class => [
            TelegramMiddlewareTimeListener::class,
        ],
        TelegramUpdateReceived::class => [
            TelegramUpdateListener::class,
        ],
    ];

    public function boot()
    {
        $this->app->bind('telegraph', fn () => new BotflowTelegraph());

        $this->app->singleton(IBotService::class, fn () =>
             new BotService(
                config('bot.middleware', []),
                config('bot.commands', []),
                config('bot.flows', []),
                config('bot.unknownCommandAction'),
                config('bot.logChannel'),
            )
        );

        $this->commands([
            BotCommand::class,
            BotSetup::class,
        ]);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
