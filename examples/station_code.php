<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$api  = new Rzd\Api();
$lang = (new Rzd\Config())->getLanguage();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'lang'            => $lang,
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);

if ($stations) {
    echo $stations;
} else {
    echo json_encode(['error' => 'Не найдено совпадений!']);
}
