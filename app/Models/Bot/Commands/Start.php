<?php

namespace App\Models\Bot\Commands;

use App\Botflow\Contracts\CommonBotCommand;

class Start extends CommonBotCommand
{

    public function commonBehavior(): void
    {
        //
    }

    public function telegramBehavior(): void
    {
        $this->botService->telegraph()->markdown('Привет!')->send();
    }

    public function consoleBehavior(): void
    {
        $this->info('Привет!');
    }

    public function alias(): string
    {
        return 'start';
    }

    public function helpMessage(): string
    {
        return 'Приветственное сообщение';
    }
}
