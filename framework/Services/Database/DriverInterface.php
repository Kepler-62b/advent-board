<?php

namespace Framework\Services\Database;

interface DriverInterface
{
    /** @throws ConnectionException */
    public function connect(): void;

    public function getDriverName(): string;
}
