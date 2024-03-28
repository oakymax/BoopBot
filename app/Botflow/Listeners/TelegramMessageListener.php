<?php

namespace App\Botflow\Listeners;

use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramMessageReceived;

class TelegramMessageListener
{

    public function __construct(protected IBotService $botService)
    {
        //
    }

    public function handle(TelegramMessageReceived $event): void
    {
        foreach ($this->botService->flows() as $flow) {
            $flow->handleChatMessage($event->message);
        }
    }
}
