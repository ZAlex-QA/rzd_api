<h1>Примеры запросов</h1>

<div style="background: sandybrown; padding: 5px; font-weight: bold">
    Обращаем внимание на то, что по новым условиям RZD.RU дату отправки нужно указывать с учетом часового пояса станции отправления
</div>

<h3>В каждый запрос можно добавлять свои параметры (Все параметры не обязательны)</h3>

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$config = new Rzd\Config();

// Устанавливаем язык
$config->setLanguage('en');

// Добавляем прокси
$config->setProxy([
    'server' => '192.168.0.1',
    'port'   => '8080',
]);

// Изменяем userAgent
$config->setUserAgent('Mozilla 5');

// Изменяем referer
$config->setReferer('rzd.ru');

$api = new Rzd\Api($config);
</pre>

<h3>Выбор маршрута в одну сторону</h3>
<a href="/examples/train_routes.php">Просмотр</a><br>
В примере выполняется поиск маршрута САНКТ-ПЕТЕРБУРГ - МОСКВА (только с билетами) на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'        => 0,
    'tfl'        => 3,
    'checkSeats' => 0,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => 'дата на завтра',
];

$routes = $api->trainRoutes($params)
</pre>

<h3>Выбор маршрута в одну сторону c измененными параметрами</h3>
<a href="/examples/train_routes_params.php">Просмотр</a><br>
В примере выполняется аналогичный поиск маршрута SANKT-PETERBURG - MOSKVA (только с билетами) на завтра, но с установленными параметрами:<br>
<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
Язык: en
UserAgent: Mozilla 5
Referer: rzd.ru
</pre>

<h3>Выбор маршрута туда-обратно</h3>
<a href="/examples/train_routes_return.php">Просмотр</a><br>
В примере выполняется поиск маршрута САНКТ-ПЕТЕРБУРГ - МОСКВА (только с билетами) на завтра туда и через 5 дней обратно

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'        => 1,
    'tfl'        => 3,
    'checkSeats' => 0,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => 'дата на завтра',
    'dt1'        => 'дата через 5 дней',
];

$routes = $api->trainRoutesReturn($params);
</pre>

<h3>Выбор вагонов</h3>
<a href="/examples/train_carriages.php">Просмотр</a><br>
В примере выполняется просмотр всех вагонов в поезде в направлением САНКТ-ПЕТЕРБУРГ - МОСКВА на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'   => 0,
    'code0' => '2004000',
    'code1' => '2000000',
    'dt0'   => 'дата на завтра',
    'time0' => 'время отправления',
    'tnum0' => 'номер вагона',
];

$carriages = $api->trainCarriages($params)
</pre>

<h3>Просмотр станций</h3>
<a href="/examples/train_station_list.php">Просмотр</a><br>
В примере выполняется поиск всех станций остановок для поезда номер 072E на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'train_num' => '072Е',
    'date'      => 'дата на завтра',
];

$stations = $api->trainStationList($params);
</pre>


<h3>Просмотр списка кодов станций</h3>
<a href="/examples/station_code.php">Просмотр</a><br>
В примере выполняется поиск кодов станций начинающихся с ЧЕБ

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$api = new Rzd\Api();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'lang'            => 'ru',
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);
</pre>

<h3>Авторизация пользователя</h3>
<a href="/examples/user_login.php">Авторизация</a><br>
В примере выполняется авторизация на сайте rzd.ru, возвращает true и устанавливает куки если авторизация выполнена успешно

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$config = new Rzd\Config();
$config->setAuth('username', 'password');

$auth = new Rzd\Auth($config);

$auth->login();
</pre>

<h3>Просмотр профиля пользователя</h3>
<a href="/examples/user_profile.php">Просмотр</a><br>
В примере выполняется просмотр данных профиля, для выполнения успешного запроса сперва необходимо авторизоваться

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$auth = new Rzd\Auth();

$profile = $auth->getProfile();
</pre>
