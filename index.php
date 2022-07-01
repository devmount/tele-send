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

$ts = new TeleForm($token, $chat, $url);
echo $ts->do();

?>
