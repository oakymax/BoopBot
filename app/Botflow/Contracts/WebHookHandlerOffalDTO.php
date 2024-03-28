<?php

namespace App\Botflow\Contracts;

use DefStudio\Telegraph\DTO\CallbackQuery;
use DefStudio\Telegraph\DTO\Message;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WebHookHandlerOffalDTO
{

    public TelegraphBot $bot;
    public TelegraphChat $chat;

    public int $messageId;
    public int $callbackQueryId;

    public Request $request;
    public Message|null $message = null;
    public CallbackQuery|null $callbackQuery = null;

    public Collection $data;

    public Keyboard $originalKeyboard;
}
