<?php

namespace App\Botflow\Flows;

use App\Botflow\Contracts\CommonBotFlow;
use App\Botflow\Telegraph\DTO\Update;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Exceptions\TelegraphException;
use Illuminate\Support\Arr;

class SetFunnyReactionToJustReceivedMessage extends CommonBotFlow
{

    /**
     * @throws TelegraphException
     */
    public function handleUpdate(Update $update): void
    {
        $this->botService->log()->info('UPDATE:', $update->toArray());
        if ($message = $update->message()) {
            $telegraph = $this->botService->telegraph();

            $telegraph->setMessageReaction(
                $message->id(),
                Arr::random($telegraph->getFunnyReactions())
            )->send();
        }
    }
}
