<?php

namespace App\Botflow\Listeners;

use App\Botflow\Contracts\IBotService;
use App\Botflow\Events\TelegramCommandReceived;

class TelegramCommandListener
{

    public function __construct(protected IBotService $botService)
    {
        //
    }

    public function handle(TelegramCommandReceived $event): void
    {

        if ($command = $this->botService->getCommand($event->command)) {
            $command->parseInputParams($event->arguments);
            $command->commonBehavior();
            $command->telegramBehavior();
        } elseif ($action = $this->botService->unknownCommandAction()) {
            $action->commonBehavior();
            $action->telegramBehavior();
        }
    }
}
