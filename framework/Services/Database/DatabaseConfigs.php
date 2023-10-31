<?php

namespace Framework\Services\Database;

class DatabaseConfigs
{
    public function setConfig(string $driver): array
    {
        $configMap = include __DIR__ . '/../../../config/databases.php';

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
                $configs['host'] = $mapParams['Host'];
                $configs['port'] = (int)$mapParams['Port'];
                break;
        }

        return $configs;
    }

}
