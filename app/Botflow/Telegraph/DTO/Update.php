<?php

namespace App\Botflow\Telegraph\DTO;

use App\Telegram\Contracts\FlowBed;
use DefStudio\Telegraph\DTO\CallbackQuery;
use DefStudio\Telegraph\DTO\InlineQuery;
use DefStudio\Telegraph\DTO\Message;
use Illuminate\Contracts\Support\Arrayable;

class Update implements Arrayable
{

    private int $id;

    private ?Message $message = null;

    private ?Message $editedMessage = null;

    private ?Message $channelPost = null;

    private ?Message $editedChannelPost = null;

    private ?InlineQuery $inlineQuery = null;

    private ?CallbackQuery $callbackQuery = null;


    public static function fromArray(array $data): Update
    {
        $udpate = new self();

        $udpate->id = $data['update_id'];

        if (isset($data['message'])) {
            $udpate->message = Message::fromArray($data['message']);
        }

        if (isset($data['edited_message'])) {
            $udpate->editedMessage = Message::fromArray($data['message']);
        }

        if (isset($data['channel_post'])) {
            $udpate->channelPost = Message::fromArray($data['channel_post']);
        }

        if (isset($data['edited_channel_post'])) {
            $udpate->editedChannelPost = Message::fromArray($data['edited_channel_post']);
        }

        if (isset($data['inline_query'])) {
            $udpate->inlineQuery = InlineQuery::fromArray($data['inline_query']);
        }

        if (isset($data['callback_query'])) {
            $udpate->callbackQuery = CallbackQuery::fromArray($data['callback_query']);
        }

        return $udpate;
    }

    public function toArray()
    {
        return [
            'update_id'           => $this->id,
            'message'             => $this->message,
            'edited_message'      => $this->editedMessage,
            'channel_post'        => $this->channelPost,
            'edited_channel_post' => $this->editedChannelPost,
            'inline_query'        => $this->inlineQuery,
            'callback_query'      => $this->callbackQuery,
        ];
    }

    public function id(): int
    {
        return $this->id();
    }

    public function message(): ?Message
    {
        return $this->message;
    }

    public function editedMessage(): ?Message
    {
        return $this->editedMessage;
    }

    public function channelPost(): ?Message
    {
        return $this->channelPost;
    }

    public function editedChannelPost(): ?Message
    {
        return $this->editedChannelPost;
    }

    public function callbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    public function inlineQuery(): ?InlineQuery
    {
        return $this->inlineQuery;
    }
}
