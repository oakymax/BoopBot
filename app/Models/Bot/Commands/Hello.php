<?php

namespace App\Models\Bot\Commands;

use App\Botflow\Contracts\CommonBotCommand;
use App\Botflow\Flows\SetFunnyReactionToJustReceivedMessage;
use DefStudio\Telegraph\Enums\ChatActions;

class Hello extends CommonBotCommand
{

    public function commonBehavior(): void
    {
        $this->botService->log()->info('Привет!');
    }

    public function consoleBehavior(): void
    {
        $this->info('Привет!');
    }

    public function telegramBehavior(): void
    {
        $this->botService->telegraph()->chatAction(ChatActions::TYPING)->send();
        $this->botService->chat()->markdown('Привет!')->dispatch()->delay(1);
        $this->botService->addFlow(SetFunnyReactionToJustReceivedMessage::class);
    }

    public function alias(): string
    {
        return 'hello';
    }

    public function helpMessage(): string
    {
        return 'Команда приветствия';
    }
}
