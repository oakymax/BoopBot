<?php

namespace App\Botflow\Listeners;

use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramUpdateReceived;

class TelegramUpdateListener
{

    public function __construct(protected IBotService $botService)
    {
        //
    }

    public function handle(TelegramUpdateReceived $event): void
    {
        foreach ($this->botService->flows() as $flow) {
            $flow->handleUpdate($event->update);
        }
    }
}
