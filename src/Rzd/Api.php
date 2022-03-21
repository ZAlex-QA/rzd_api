<?php

namespace Rzd;

use GuzzleHttp\Exception\GuzzleException;

class Api
{
    public const ROUTES_LAYER = 5827;
    public const CARRIAGES_LAYER = 5764;

    public const STATIONS_STRUCTURE_ID = 704;

    /**
     * Путь получения маршрутов
     */
    protected string $path = 'https://pass.rzd.ru/timetable/public/';

    /**
     * Путь получения кодов станций
     */
    protected string $suggestionPath = 'https://pass.rzd.ru/suggester';

    /**
     * Путь получения станций маршрута
     */
    protected string $stationListPath = 'https://pass.rzd.ru/ticket/services/route/basicRoute';

    private Query $query;
    private string $lang;

    /**
     * Api constructor.
     *
     * @param Config|null $config
     */
    public function __construct(Config $config = null)
    {
        if (! $config) {
            $config = new Config();
        }

        $this->lang = $config->getLanguage();
        $this->path .= $this->lang;
        $this->query = new Query($config);
    }

    /**
     * Получает маршруты в 1 точку
     *
     * @param array $params Массив параметров
     *
     * @return array<object>
     * @throws GuzzleException
     */
    public function trainRoutes(array $params): array
    {
        $layer = [
            'layer_id' => static::ROUTES_LAYER,
        ];
        $routes = $this->query->get($this->path, $layer + $params);

        return $routes->tp[0]->list;
    }

    /**
     * Получает маршруты туда-обратно
     *
     * @param  array $params Массив параметров
     *
     * @return array<object>
     * @throws GuzzleException
     */
    public function trainRoutesReturn(array $params): array
    {
        $layer = [
            'layer_id' => static::ROUTES_LAYER,
        ];
        $routes = $this->query->get($this->path, $layer + $params);

        return [
            'forward' => $routes->tp[0]->list,
            'back'    => $routes->tp[1]->list
        ];
    }

    /**
     * Получение списка вагонов
     *
     * @param  array $params Массив параметров
     *
     * @return array<object>
     * @throws GuzzleException
     */
    public function trainCarriages(array $params): array
    {
        $layer = [
            'layer_id' => static::CARRIAGES_LAYER,
        ];
        $carriages = $this->query->get($this->path, $layer + $params);

        return [
            'cars'           => $carriages->lst[0]->cars ?? null,
            'functionBlocks' => $carriages->lst[0]->functionBlocks ?? null,
            'schemes'        => $carriages->schemes ?? null,
            'companies'      => $carriages->insuranceCompany ?? null,
        ];
    }

    /**
     * Получение списка станций
     *
     * @param  array $params Массив параметров
     *
     * @return array
     * @throws GuzzleException
     */
    public function trainStationList(array $params): array
    {
        $layer = [
            'STRUCTURE_ID' => static::STATIONS_STRUCTURE_ID,
        ];
        $stations = $this->query->get($this->stationListPath, $layer + $params);

        return [
            'train'  => $stations->data->trainInfo,
            'routes' => $stations->data->routes,
        ];
    }

    /**
     * Получение списка кодов станций
     *
     * @param  array $params Массив параметров
     *
     * @return array
     * @throws GuzzleException
     */
    public function stationCode(array $params): array
    {
        $lang = [
            'lang' => $this->lang,
        ];

        $routes = $this->query->get($this->suggestionPath, $lang + $params, 'GET');
        $stations = [];

        if ($routes) {
            foreach ($routes as $station) {
                if (mb_stristr($station->n, $params['stationNamePart'])) {
                    $stations[] = [
                        'station' => $station->n,
                        'code' => $station->c,
                    ];
                }
            }
        }

        return $stations;
    }
}
