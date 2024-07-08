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
    'tnum0'      => $_GET['tnum0'],
    'time0'      => $_GET['time0'],
    'dt0'        => $_GET['dt0']  ?? $tomorrow->format('d.m.Y'),
    'dir'        => $_GET['dir'] ?? 0,
];
header('Content-type: application/json');
echo $api->trainCarriages($params);
?>
