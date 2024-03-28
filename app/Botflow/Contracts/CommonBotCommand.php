<?php

namespace App\Botflow\Contracts;

use Illuminate\Console\Concerns\InteractsWithIO;

abstract class CommonBotCommand extends CommonBotAction implements IBotCommand
{

    use InteractsWithIO;

    protected string $inputParams = '';

    public abstract function alias(): string;

    public abstract function helpMessage(): string;

    public function parseInputParams(string $rawInputParamsString): void
    {
        $this->inputParams = $rawInputParamsString;
    }
}
