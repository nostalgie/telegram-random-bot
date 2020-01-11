<?php
require 'vendor/autoload.php';

use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use \unreal4u\TelegramAPI\TgLog;
use \unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use \unreal4u\TelegramAPI\Telegram\Types\Update;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$updateData = json_decode(file_get_contents('php://input'), true);
$update = new Update($updateData);

if ($update->message->text === getenv('BOT_REQUEST_MESSAGE')) {
    $loop = Factory::create();
    $tgLog = new TgLog(getenv('BOT_API_KEY'), new HttpClientRequestHandler($loop));

    $list = explode('|', getenv('BOT_RANDOM_USERS'));
    $sendMessage = new SendMessage();
    $sendMessage->chat_id = $update->message->chat->id;
    $sendMessage->text = $list[mt_rand(0, count($list) - 1)];
    $firstMessagePromise = $tgLog->performApiRequest($sendMessage);

    $loop->run();
}
