<?php

namespace App\Botflow\Contracts;

use App\Botflow\Telegraph\DTO\Update;

interface IBotMiddleware
{

    public function __construct(IBotService $botService, array $params = []);

    public function handle(Update $update): void;
}
