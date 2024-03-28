<?php

return [
    'token' => env('BOT_TOKEN'),

    'name' => env('BOT_NAME'),

    'menu' => [
        'help' => 'Справка',
    ],

    'middleware' => [

    ],

    'commands' => [
        \App\Models\Bot\Commands\Hello::class,
    ],

    'flows' => [

    ],

    'unknownCommandAction' => null,

    'logChannel' => 'telegraph',
];
