<?php

namespace Framework\Services;

use App\Controllers\DefaultController;
use Symfony\Component\HttpFoundation\Request;

class ParseURLService
{
    // @TODO вынести пути к файлам из классов
    private const APP_MAP = 'config/app_route_map.json';
    private const API_MAP = 'config/api_route_map.json';
    public array $matchURL = [];
    private array $parseURL = [];


    public function __construct(Request $request)
    {
        if (str_contains($request->getPathInfo(), 'api')) {
            $this->matchURL = $this->matchApiURL($request);
        } else {
            $this->matchURL = $this->matchAppURL($request);
        }
    }

    private function getRouteMap(string $fileMap): array
    {
        $resourse = fopen($fileMap, "r+");
        $routeMap = json_decode(file_get_contents($fileMap), JSON_OBJECT_AS_ARRAY);
        fclose($resourse);
        return $routeMap;
    }

    /**
     * @TODO использовать поле requestParams при 404 Not Found
     */
    private function matchAppURL(Request $request): array
    {
        $incomingURL = $request->getPathInfo();
        $queryString = $request->query->all();
        $routeMap = $this->getRouteMap(self::APP_MAP);

        foreach ($routeMap as $uriMap => $routeParamsMap) {
            if ($uriMap === $incomingURL) {
                $this->matchURL = [
                    'interface' => null,
                    'incomingURL' => $uriMap,
                    'controller' => $routeParamsMap['controller'],
                    'action' => $routeParamsMap['action'],
                    'action_params' => $queryString,
                ];
                return $this->matchURL;
            }
        }

        /**
         * обработка несовпадающего URL запроса с картой маршрутов
         * @TODO разобраться с условием
         * @TODO привязать к конкретному контроллеру?
         */
        $this->matchURL = [
            'interface' => null,
            'incomingURL' => $incomingURL,
            'controller' => DefaultController::class,
            'action' => 'notFound',
            'action_params' => $queryString,
        ];

        return $this->matchURL;
    }

    /**
     * @todo обрабатывать несуществующие роуты, приходящие c префиксом /api
     * @todo обрабатывать несколько параметров для экшена из URL
     */
    public function matchApiURL(Request $request)
    {
        $incomingURL = $request->getPathInfo();
        $routeMap = $this->getRouteMap(self::API_MAP);

        foreach ($routeMap as $urlMap => $routeParamsMap) {
            if (preg_split("/\d+/", $incomingURL) === preg_split("/{(\w*)}/", $urlMap)) {
                if (count(preg_split("/\/\w*/", $incomingURL)) === count(preg_split("/\/\w*/", $urlMap)))
                    $this->matchURL = [
                        'interface' => 'api',
                        'incomingURL' => $incomingURL,
                        'controller' => $routeParamsMap['controller'],
                        'action' => $routeParamsMap['action'],
                        'action_params' => [
                            $routeParamsMap['action_params'] => preg_replace("/\/\D*/", '', $incomingURL)
                        ],
                    ];

                return $this->matchURL;
            }
        }
    }

}