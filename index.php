<?php
namespace Devmount\TeleSend;

require_once 'vendor/autoload.php';
require_once 'src/form.php';

// get environment variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// config
$token = $_ENV['TOKEN']; // telegram bot token
$chat  = $_ENV['CHAT'];  // telegram chat id to post to
$url   = 'https://api.telegram.org/bot' . $token . '/sendMessage';
$conf  = json_decode(file_get_contents('config.json'), true);

// init form and render it
$ts = new TeleForm($token, $chat, $url, $conf);
$ts->render();
