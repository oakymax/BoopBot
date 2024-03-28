<?php

namespace App\Botflow\Contracts;

use App\Botflow\Telegraph\BotflowTelegraph;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

interface IBotService
{

    public function log(): LoggerInterface;

    public function setBot(TelegraphBot $bot): void;

    public function bot(): TelegraphBot;

    public function setChat(TelegraphChat $chat): void;

    public function chat(): TelegraphChat;

    public function flows(): Collection;

    public function addFlow(string $flowClass, array $params = []): self;

    public function addCommand(string $commandClass, array $params = []): self;

    public function getCommand(string $alias): ?IBotCommand;

    public function addAction(string $actionClass, array $params = []): self;

    public function nextAction(): ?IBotAction;

    public function addMiddleware(string $middlewareClass, array $params = []): self;

    public function nextMiddleware(): ?IBotMiddleware;

    public function unknownCommandAction(): ?IBotAction;

    public function telegraph(): BotflowTelegraph;
}
