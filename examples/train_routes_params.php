<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new Rzd\Config();

// Устанавливаем язык
$config->setLanguage('en');

// Подключаемся через прокси
/*$config->setProxy([
    'server' => '192.168.0.1',
    'port'   => '8080',
]);*/

// Изменяем userAgent
$config->setUserAgent('Mozilla 5');

// Изменяем referer
$config->setReferer('rzd.ru');

$api = new Rzd\Api($config);

$start = new DateTime();
$date0 = $start->modify('+1 day');

$params = [
    'dir'        => 0,
    'tfl'        => 3,
    'checkSeats' => 1,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => $date0->format('d.m.Y'),
];

echo $api->trainRoutes($params);
