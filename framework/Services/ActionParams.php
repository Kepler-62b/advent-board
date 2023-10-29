<?php

namespace Framework\Services;

class ActionParams
{
    protected readonly array $actionParams;

    public function __construct(array $actionParams)
    {
        $this->actionParams = $actionParams;
    }

    public function get(string $key): ?string
    {
        if (array_key_exists($key, $this->actionParams)) {
            return $this->actionParams[$key];
        } else {
            return null;
        }
    }


}