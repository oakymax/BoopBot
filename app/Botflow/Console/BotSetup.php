<?php

namespace App\Botflow\Console;

use App\Botflow\Contracts\IBotService;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Console\Command;

class BotSetup extends Command
{

    protected $signature = 'bot:setup';

    protected $description = 'Настройка бота, регистрация веб-хука и меню';

    public function handle(IBotService $service)
    {
        $botModel = config('telegraph.models.bot');
        $token = config('bot.token');
        $name = config('bot.name');
        $url = env('APP_URL');

        $this->info('Токен: ' . $token);
        $this->info('Имя бота: ' . $name);
        $this->info('URL: ' . $url);

        if ($token && $name && $url) {
            /** @var TelegraphBot $bot */
            $bot = $botModel::query()->where('token', '=', $token)->first();

            if (empty($bot)) {
                $bot = $botModel::create([
                    'token' => $token,
                    'name' => $name,
                ]);
                $this->info('Зарегистрирован новый бот, ID: ' . $bot->id);
            } else {
                $this->info('Найден бот, ID: ' . $bot->id);
            }

            $this->info('Регистрация хука...');
            $bot->registerWebhook()->send();
            $this->info('Готово');

            if ($menu = config('bot.menu')) {
                $this->info('Регистрация меню...');
                $bot->registerCommands($menu)->send();
                $this->info('Готово');
            }
        } else {
            $this->warn('Для регистрации бота необходимы параметры конфигурации bot.token, bot.name, а также параментр .env APP_URL');
        }

        return self::SUCCESS;
    }
}
