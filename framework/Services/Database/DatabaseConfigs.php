<?php

namespace Framework\Services\Database;

class DatabaseConfigs
{

    private function getConfig(): array
    {
        return [
            'PostgreSQL' => [
                'Driver' => 'pgsql',
                'Host' => 'postgres',
                'Port' => '5432',
                'Database' => 'adverts-board',
                'User' => 'postgres',
                'Password' => 'secret',
            ],
            'MySQL' => [
                'Driver' => 'mysql',
                'Host' => 'mysql',
                'Database' => 'adverts-board',
                'User' => 'root',
                'Password' => 'secret',
            ],
            'Redis' => [
                'Host' => 'redis',
                'Port' => '6379',
            ]
        ];
    }

    public function setConfig(string $driver): array
    {
        $configMap = $this->getConfig();
        $mapParams = $configMap[$driver];

        $configs = [];

        switch ($driver) {
            case 'MySQL':
                $configs[] = strtr('Driver:host=Host;dbname=Database', $mapParams);
                $configs[] = $mapParams['User'];
                $configs[] = $mapParams['Password'];
                break;
            case 'PostgreSQL':
                $configs[] = strtr('Driver:host=Host;port=Port;dbname=Database', $mapParams);
                $configs[] = $mapParams['User'];
                $configs[] = $mapParams['Password'];
                break;
            case 'Redis':
                $configs[] = $mapParams['Host'];
                $configs[] = $mapParams['Port'];
                break;
        }

        return $configs;
    }

}
