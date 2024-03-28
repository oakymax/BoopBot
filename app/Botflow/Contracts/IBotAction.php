<?php

namespace App\Botflow\Contracts;

interface IBotAction
{

    public function __construct(IBotService $botService, array $params = []);

    public function commonBehavior(): void;

    /**
     * Executes in console commands after common behavior
     * @return void
     */
    public function consoleBehavior(): void;

    /**
     * Executes in private telegram chat after common behavior
     * @return void
     */
    public function telegramBehavior(): void;
}
