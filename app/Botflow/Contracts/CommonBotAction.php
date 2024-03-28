<?php

namespace App\Botflow\Contracts;

use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class CommonBotAction implements IBotAction
{
    use InteractsWithIO;

    protected string $inputParams = '';

    public function __construct(protected IBotService $botService, protected array $params = [])
    {
        $this->output = new ConsoleOutput();
    }

    public abstract function commonBehavior(): void;

    public function consoleBehavior(): void
    {
        // do nothing by default
    }

    public function telegramBehavior(): void
    {
        // do nothing by default
    }
}
