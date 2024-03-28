<?php

namespace App\Botflow\Console;

use App\Botflow\Contracts\IBotService;
use Illuminate\Console\Command;

class BotCommand extends Command
{
    protected $signature = 'bot:command {cmd} {params?}';

    protected $description = 'Команда бота';

    public function handle(IBotService $botService): void
    {
        $command = $this->argument('cmd');
        $params = $this->argument('params') ?: '';

        $command = $botService->getCommand($command);
        $command->parseInputParams($params);
        $command->commonBehavior();
        $command->consoleBehavior();
    }
}
