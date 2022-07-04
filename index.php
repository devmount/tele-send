<?php
require_once 'vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;
use TeleSend\Form\Form;

// get environment variables
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// config
$token = $_ENV['TOKEN']; // telegram bot token
$chat  = $_ENV['CHAT'];  // telegram chat id to post to
$url   = 'https://api.telegram.org/bot' . $token . '/sendMessage';
$conf  = Yaml::parseFile('config.yml');

// init form and render it
$ts = new Form($token, $chat, $url, $conf);
$ts->render();
