<?php

use PHPUnit\Framework\TestCase;
use Rzd\Api;

class ApiTest extends TestCase
{
    /**
     * var Api
     */
    private $api;

    /**
     * @var string
     */
    private $date0;

    /**
     * @var string
     */
    private $date1;

    /**
     * @throws Exception
     */
    protected function setUp()
    {
        $this->api = new Api();

        $start = new DateTime();
        $this->date0 = $start->modify('+1 day');
        $this->date1 = $start->modify('+5 day');
    }

    /**
     * Тест получения маршрутов
     *
     * @runInSeparateProcess
     */
    public function testTrainRoutes(): void
    {
        $params = [
            'dir'        => 0,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
        ];

        $trainRoutes = json_decode($this->api->trainRoutes($params), true);

        $this->assertIsArray($trainRoutes);
        $this->assertArrayHasKey('route0', $trainRoutes[0]);
        $this->assertContains('С-ПЕТЕР-ГЛ', $trainRoutes[0]['route0']);
    }

    /**
     * Тест получения маршрутов туда-обратно
     *
     * @runInSeparateProcess
     */
    public function testTrainRoutesReturn(): void
    {
        $params = [
            'dir'        => 1,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
            'dt1'        => $this->date1->format('d.m.Y'),
        ];

        $trainRoutesReturn = json_decode($this->api->trainRoutesReturn($params), true);

        $this->assertIsArray($trainRoutesReturn[0]);
        $this->assertArrayHasKey('route0', $trainRoutesReturn[0][0]);
        $this->assertContains('С-ПЕТЕР-ГЛ', $trainRoutesReturn[0][0]['route0']);
    }

    /**
     * Тест получения вагонов
     *
     * @runInSeparateProcess
     */
    public function testTrainCarriages(): void
    {
        $params = [
            'dir'        => 0,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
        ];

        $routes = $this->api->trainRoutes($params);

        if ($routes) {
            $routes = json_decode($routes);

            $params = [
                'dir'   => 0,
                'code0' => '2004000',
                'code1' => '2000000',
                'dt0'   => $this->date0->format('d.m.Y'),
                'time0' => $routes[0]->trTime0,
                'tnum0' => $routes[0]->number,
            ];

            $trainCarriages = json_decode($this->api->trainCarriages($params), true);

            $this->assertIsArray($trainCarriages);
            $this->assertArrayHasKey('cars', $trainCarriages);
            $this->assertArrayHasKey('cnumber', $trainCarriages['cars'][0]);
        }
    }

    /**
     * Тест просмотра станций
     *
     * @runInSeparateProcess
     */
    public function testTrainStationList(): void
    {
        $params = [
            'train_num' => '072Е',
            'date'      => $this->date0->format('d.m.Y'),
        ];

        $trainStationList = json_decode($this->api->trainStationList($params), true);

        $this->assertIsArray($trainStationList);
        $this->assertArrayHasKey('train', $trainStationList);
        $this->assertContains('072Е', $trainStationList['train']['Number']);
    }

    /**
     * Тест кодов станций
     *
     * @runInSeparateProcess
     */
    public function testStationCode(): void
    {
        $params = [
            'stationNamePart' => 'ЧЕБ',
            'lang'            => 'ru',
            'compactMode'     => 'y',
        ];

        $stationCode = json_decode($this->api->stationCode($params), true);

        $this->assertIsArray($stationCode);

        $cities = [];
        foreach($stationCode as $station) {
            $cities[] = $station['station'];
        }

        $this->assertContains('ЧЕБОКСАРЫ', $cities);
    }
}
