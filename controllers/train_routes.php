<?php
require dirname(__DIR__) . '/vendor/autoload.php';
$config = new Rzd\Config();
$config->setUserAgent('Mozilla 5');
$config->setReferer('https://rzd.ru');
$api = new Rzd\Api($config);
$tomorrow = new DateTime('tomorrow');
$params = [
    'code0'      => $_GET['code0'],
    'code1'	     => $_GET['code1'],
    'dir'        => $_GET['dir'] ?? 0,
    'tfl'        => $_GET['tfl'] ?? 3,
    'checkSeats' => $_GET['checkSeats'] ?? 1,
    'dt0'        => $_GET['dt0'] ?? $tomorrow->format('d.m.Y'),
    'md'         => $_GET['md'] ?? 0,
];
header('Content-type: application/json');
echo $api->trainRoutes($params);
?>
