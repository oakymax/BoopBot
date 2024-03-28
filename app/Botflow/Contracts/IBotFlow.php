<?php

namespace App\Botflow\Contracts;

use App\Botflow\Telegraph\DTO\Update;
use App\Services\AioBotService;
use DefStudio\Telegraph\DTO\CallbackQuery;
use DefStudio\Telegraph\DTO\InlineQuery;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\DTO\User;

interface IBotFlow
{

    public function __construct(IBotService $botService, array $params = []);

    public function handleCommand(string $command, string $parameter): void;

    public function handleUpdate(Update $update): void;

    public function handleChatMessage(Message $message): void;

    public function handleEditedMessage(Message $message): void;

    public function handleChannelPost(Message $message): void;

    public function handleInlineQuery(InlineQuery $inlineQuery): void;

    public function handleCallbackQuery(CallbackQuery $callbackQuery): void;

    public function handleChatMemberJoined(User $member): void;

    public function handleChatMemberLeft(User $member): void;
}
