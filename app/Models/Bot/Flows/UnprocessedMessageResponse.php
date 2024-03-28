<?php

namespace App\Models\Bot\Flows;

use App\Botflow\Contracts\CommonBotFlow;
use App\Botflow\Flows\SetFunnyReactionToJustReceivedMessage;
use DefStudio\Telegraph\DTO\Message;

class UnprocessedMessageResponse extends CommonBotFlow
{

    public function handleChatMessage(Message $message): void
    {
        if ($this->botService->bot()->storage()->get("message.{$message->id()}.processed")) {
            return;
        }

        $this->botService->addFlow(SetFunnyReactionToJustReceivedMessage::class);
    }
}
