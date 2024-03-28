<?php

namespace App\Botflow\Contracts;

use App\Botflow\Commands\StopFlow;
use App\Botflow\Eloquent\FlowState;
use App\Botflow\Exceptions\RuntimeDataInconsistencyErrorException;
use App\Botflow\Exceptions\RuntimeUnexpectedErrorException;
use DefStudio\Telegraph\DTO\Message;

abstract class CommonBotFlowWithState extends CommonBotFlow
{

    protected ?FlowState $state = null;

    /**
     * @param IBotService $botService
     * @param array       $params
     *
     * Params can contain `id` attribute -- if so then flow will be restored from FlowState model (eloquent)
     * Other params will be passed to `params` attribute of state model instance
     *
     * @throws RuntimeUnexpectedErrorException
     * @throws RuntimeDataInconsistencyErrorException
     */
    public function __construct(IBotService $botService, array $params = [])
    {
        parent::__construct($botService, $params);

        if (!empty($params['id'])) {
            $this->state = FlowState::query()->findOrFail($params['id']);

            if (empty($this->state)) {
                throw new RuntimeDataInconsistencyErrorException('Requested flow state does not exist');
            }
        }

        if (empty($this->state)) {
            $this->state         = new FlowState();
            $this->state->status = FlowStatus::ACTIVE;
            $this->state->class  = self::class;
        } elseif (!is_a($this, $this->state->class)) {
            throw new RuntimeDataInconsistencyErrorException('Requested flow state belongs to other flow class');
        }

        unset($params['id']);
        $this->state->params = array_merge($this->state->params, $params);

        $this->store();
    }

    /**
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function start(): void
    {
        $this->state->status = FlowStatus::ACTIVE;
        $this->store();
    }

    /**
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function interrupt(): void
    {
        $this->state->status = FlowStatus::INTERRUPTED;
        $this->store();
    }

    /**
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function dispatch(): void
    {
        $this->state->status = FlowStatus::QUEUED;
        $this->store();
    }

    /**
     * @param Message $message
     *
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function handleChatMessage(Message $message): void
    {
        parent::handleChatMessage($message);

        $this->state->messages[$message->id()] = $message;
        $this->store();
    }

    /**
     * @param Message $message
     *
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function handleEditedMessage(Message $message): void
    {
        parent::handleEditedMessage($message);

        $this->state->messages[$message->id()] = $message;
        $this->store();
    }

    /**
     * @param string $command
     * @param string $parameter
     *
     * @return void
     */
    public function handleCommand(string $command, string $parameter): void
    {
        parent::handleCommand($command, $parameter);

        $this->botService->addCommand(StopFlow::class, ['id' => $this->id()]);
    }

    protected function id(): int
    {
        return $this->state->id;
    }

    /**
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    protected function store(): void
    {
        try {
            $this->state->saveOrFail();
        } catch (\Throwable $e) {
            throw new RuntimeUnexpectedErrorException('Flow state save failed', 0, $e);
        }
    }

    /**
     * @param int $id
     *
     * @return CommonBotFlowWithState
     * @throws RuntimeDataInconsistencyErrorException
     */
    public static function restore(int $id): CommonBotFlowWithState
    {
        /** @var FlowState $state */
        $state = FlowState::query()->findOrFail($id);

        if (!is_subclass_of($state->class, CommonBotFlowWithState::class)) {
            throw new RuntimeDataInconsistencyErrorException('Flow state record contains invalid class');
        }

        return new $state->class(app('telegram'), ['id' => $id]);
    }
}
