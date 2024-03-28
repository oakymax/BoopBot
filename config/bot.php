<?php

use App\Models\Bot\Commands\Hello;
use App\Models\Bot\Commands\Help;
use App\Models\Bot\Commands\Start;
use App\Models\Bot\Flows\UnprocessedMessageResponse;

return [
    'token' => env('BOT_TOKEN'),

    'name' => env('BOT_NAME'),

    'menu' => [
        'help' => 'Справка',
    ],

    'middleware' => [

    ],

    'commands' => [
        Hello::class,
        Help::class,
        Start::class,
    ],

    'flows' => [
        UnprocessedMessageResponse::class,
    ],

    'unknownCommandAction' => null,

    'logChannel' => 'telegraph',
];
