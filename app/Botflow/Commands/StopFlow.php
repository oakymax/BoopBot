<?php

namespace App\Botflow\Commands;

use App\Botflow\Contracts\CommonBotCommand;
use App\Botflow\Contracts\CommonBotFlowWithState;
use App\Botflow\Contracts\IBotService;
use App\Botflow\Exceptions\RuntimeConfigurationErrorException;
use App\Botflow\Exceptions\RuntimeDataInconsistencyErrorException;
use App\Botflow\Exceptions\RuntimeUnexpectedErrorException;

class StopFlow extends CommonBotCommand
{

    protected CommonBotFlowWithState $state;

    /**
     * @throws RuntimeConfigurationErrorException
     * @throws RuntimeDataInconsistencyErrorException
     */
    public function __construct(IBotService $botService, array $params = [])
    {
        parent::__construct($botService, $params);

        if (empty($params['id'])) {
            throw new RuntimeConfigurationErrorException('StopFlow command must have id parameter');
        }

        $this->state = CommonBotFlowWithState::restore($params['id']);
    }

    public function alias(): string
    {
        return 'stop';
    }

    public function helpMessage(): string
    {
        return "Остановить текущий диалог с ботом " . $this->botService->bot()->name;
    }

    /**
     * @return void
     * @throws RuntimeUnexpectedErrorException
     */
    public function commonBehavior(): void
    {
        $this->state->interrupt();
    }
}
