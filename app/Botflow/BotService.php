<?php

namespace App\Botflow;

use App\Botflow\Contracts\IBotAction;
use App\Botflow\Contracts\IBotCommand;
use App\Botflow\Contracts\IBotFlow;
use App\Botflow\Contracts\IBotMiddleware;
use App\Botflow\Contracts\IBotService;
use App\Botflow\Exceptions\RuntimeConfigurationErrorException;
use App\Botflow\Telegraph\BotflowTelegraph;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class BotService implements IBotService
{


    protected ?IBotAction $unknownCommandAction = null;

    protected BotflowTelegraph $telegraph;

    protected LoggerInterface $log;

    private TelegraphBot $bot;

    private ?TelegraphChat $chat = null;

    /** @var IBotFlow[] */
    private array $flows = [];

    /** @var IBotCommand[] */
    private array $commands = [];

    /** @var IBotAction[] */
    private array $actions = [];

    /** @var IBotMiddleware[] */
    private array $middleware = [];

    /**
     * @throws RuntimeConfigurationErrorException
     */
    public function __construct(
        array $coreMiddleware,
        array $coreCommands,
        array $coreFlows,
        ?string $unknownCommandActionClass = null,
        ?string $logChannel = null,
    )
    {
        $this->log = $logChannel ? Log::channel($logChannel) : Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/bot.log'),
        ]);

        $this->telegraph = app('telegraph');

        foreach ($coreMiddleware as $key => $value) {
            $coreCommandClass = is_int($key) ? $value : $key;
            $coreCommandParams = is_array($value) ? $value : [];
            $this->addMiddleware($coreCommandClass, $coreCommandParams);
        }

        foreach ($coreCommands as $key => $value) {
            $coreCommandClass = is_int($key) ? $value : $key;
            $coreCommandParams = is_array($value) ? $value : [];
            $this->addCommand($coreCommandClass, $coreCommandParams);
        }

        foreach ($coreFlows as $key => $value) {
            $coreFlowClass = is_int($key) ? $value : $key;
            $coreFlowParams = is_array($value) ? $value : [];
            $this->addFlow($coreFlowClass, $coreFlowParams);
        }

        if (!empty($unknownCommandActionClass)) {
            if (is_subclass_of($unknownCommandActionClass, IBotAction::class)) {
                $this->unknownCommandAction = new $unknownCommandActionClass();
            } else {
                throw new RuntimeConfigurationErrorException("UnknownCommandAction class must implement IBotAction interface");
            }
        }
    }

    public function log(): LoggerInterface
    {
        return $this->log;
    }

    public function setBot(TelegraphBot $bot): void
    {
        $this->telegraph = $this->telegraph->bot($bot);
        $this->bot = $bot;
    }

    public function setChat(TelegraphChat $chat): void
    {
        $this->telegraph = $this->telegraph->chat($chat);
        $this->chat = $chat;
    }

    public function telegraph(): BotflowTelegraph
    {
        return $this->telegraph;
    }

    public function bot(): TelegraphBot
    {
        return $this->bot;
    }

    public function chat(): TelegraphChat
    {
        return $this->chat;
    }

    public function flows(): Collection
    {
        return collect($this->flows);
    }

    /**
     * @throws RuntimeConfigurationErrorException
     */
    public function addFlow(string $flowClass, array $params = []): self
    {
        if (!is_subclass_of($flowClass, IBotFlow::class)) {
            throw new RuntimeConfigurationErrorException("Flow must \"{$flowClass}\" implement IBotFlow interface\"" . IBotFlow::class . "\"");
        }

        $flow = new $flowClass($this, $params);

        $this->flows[] = $flow;
        $this->log->debug('Registered bot Flow: ' . $flow::class);

        return $this;
    }

    /**
     * @throws RuntimeConfigurationErrorException
     */
    public function addCommand(string $commandClass, array $params = []): IBotService
    {

        if (!is_subclass_of($commandClass, IBotCommand::class)) {
            throw new RuntimeConfigurationErrorException("Command must implement IBotCommand interface");
        }

        $command = new $commandClass($this, $params);

        if (!isset($this->commands[$command->alias()])) {
            $this->commands[$command->alias()] = $command;
            $this->log->debug('Registered bot Command: ' . $command::class);
        } else {
            throw new RuntimeConfigurationErrorException("Command alias must be unique");
        }

        return $this;
    }

    public function getCommand(string $alias): ?IBotCommand
    {
        return $this->commands[$alias] ?? null;
    }

    public function unknownCommandAction(): ?IBotAction
    {
        return $this->unknownCommandAction;
    }

    /**
     * @throws RuntimeConfigurationErrorException
     */
    public function addAction(string $actionClass, array $params = []): IBotService
    {
        if (!is_subclass_of($actionClass, IBotAction::class)) {
            throw new RuntimeConfigurationErrorException("Action must implement IBotAction interface");
        }

        $action = new $actionClass($this, $params);
        $this->actions[] = $action;

        return $this;
    }

    public function nextAction(): ?IBotAction
    {
        return array_shift($this->actions);
    }

    public function addMiddleware(string $middlewareClass, array $params = []): self
    {
        if (!is_subclass_of($middlewareClass, IBotMiddleware::class)) {
            throw new RuntimeConfigurationErrorException("Command must implement IBotMiddleware interface");
        }

        $middleware = new $middlewareClass($this, $params);

        $this->middleware[] = $middleware;
        $this->log->debug('Registered bot Middleware: ' . $middleware::class);

        return $this;
    }

    public function nextMiddleware(): ?IBotMiddleware
    {
        return array_shift($this->middleware);
    }
}
