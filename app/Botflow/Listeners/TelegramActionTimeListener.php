<?php

namespace App\Botflow\Listeners;

use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramActionTime;

class TelegramActionTimeListener
{

    public function __construct(protected IBotService $botService)
    {
        //
    }

    public function handle(TelegramActionTime $event): void
    {
        while ($action = $this->botService->nextAction()) {
            $action->commonBehavior();
            $action->telegramBehavior();
        }
    }
}
