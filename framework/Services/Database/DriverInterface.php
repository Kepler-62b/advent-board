<?php

namespace Framework\Services\Database;

interface DriverInterface
{
    /** @throws DriverException */
    public function connect(): void;

    public function getDriverName(): string;
}
