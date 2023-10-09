<?php

namespace App\Service;

trait SingletonTrait
{
    private static array $instances = [];
    protected function __construct() {}

    protected function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): object
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

//        var_dump(self::$instances);
//        var_dump(debug_backtrace());
        return self::$instances[$cls];
    }
}