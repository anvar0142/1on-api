<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function webhook()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        Telegram::sendMessage(['chat_id' => '796167821', 'text' => 'test']);

        return 'ok';
    }
}
