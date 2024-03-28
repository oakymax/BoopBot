<?php

namespace App\Botflow\Contracts;

use App\Botflow\Telegraph\DTO\Update;
use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class CommonBotMiddleware implements IBotMiddleware
{
    use InteractsWithIO;

    protected string $inputParams = '';

    public function __construct(protected IBotService $botService, protected array $params = [])
    {
        $this->output = new ConsoleOutput();
    }

    public abstract function handle(Update $update): void;
}
