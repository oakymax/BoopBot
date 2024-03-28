<?php

namespace App\Botflow\Listeners;

use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramMiddlewareTime;

class TelegramMiddlewareTimeListener
{

    public function __construct(protected IBotService $botService)
    {
        //
    }

    public function handle(TelegramMiddlewareTime $event): void
    {
        while ($middleware = $this->botService->nextMiddleware()) {
            $middleware->handle($event->update);
        }
    }
}
