<?php

namespace Framework\Services\Database;

use Framework\Services\SingletonTrait;

class PDOConnection extends \PDO
{
    use SingletonTrait;

    private string $dsn;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $this->initPDOParams();
        parent::__construct($this->dsn, $this->user, $this->pass);
    }

    private function getConfigMap(): array
    {
        return json_decode(file_get_contents('/app/config/database_config.json'), JSON_OBJECT_AS_ARRAY);
    }

    private function initPDOParams(): void
    {
        $configMap = $this->getConfigMap();
        $driverPDO = $configMap['PDO_driver_param'];
        $mapParams = $configMap[$driverPDO];

        switch ($driverPDO) {
            case "MySQL":
                $this->dsn = strtr("Driver:host=Host;dbname=Database", $mapParams);
            case "PostgreSQL":
                $this->dsn = strtr("Driver:host=Host;port=5432;dbname=Database", $mapParams);
        }
        $this->user = $mapParams['User'];
        $this->pass = $mapParams['Password'];
    }
}
