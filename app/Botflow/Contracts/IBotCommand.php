<?php

namespace App\Botflow\Contracts;

interface IBotCommand extends IBotAction
{


    public function alias(): string;

    /**
     * @return string markdown
     */
    public function helpMessage(): string;

    public function parseInputParams(string $rawInputParamsString): void;
}
