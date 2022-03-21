<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$api  = new Rzd\Api();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);

if ($stations) {
    var_dump($stations);
} else {
    echo 'Не найдено совпадений!';
}
