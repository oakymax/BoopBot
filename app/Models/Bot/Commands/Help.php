<?php

namespace App\Models\Bot\Commands;

use App\Botflow\Contracts\CommonBotCommand;

class Help extends CommonBotCommand
{

    private string $helpText;

    public function commonBehavior(): void
    {
        $this->helpText =<<<MD
Привет!

Это бот помогает развивать и изучать свою интуицию.
MD;
    }

    public function telegramBehavior(): void
    {
        $this->botService->telegraph()->markdown($this->helpText)->send();
    }

    public function consoleBehavior(): void
    {
        $this->info($this->helpText);
    }

    public function alias(): string
    {
        return 'help';
    }

    public function helpMessage(): string
    {
        return 'Справка по боту';
    }
}
