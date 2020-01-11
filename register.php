<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use \React\EventLoop\Factory;
use \unreal4u\TelegramAPI\HttpClientRequestHandler;
use \unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use \unreal4u\TelegramAPI\Abstracts\TraversableCustomType;
use \unreal4u\TelegramAPI\TgLog;
use \unreal4u\TelegramAPI\Telegram\Methods\SetWebhook;

$loop = Factory::create();

$setWebhook = new SetWebhook();
$setWebhook->url = getenv('BOT_WEBHOOK_URL');

$tgLog = new TgLog(getenv('BOT_API_KEY'), new HttpClientRequestHandler($loop));
$tgLog->performApiRequest($setWebhook);
$loop->run();
