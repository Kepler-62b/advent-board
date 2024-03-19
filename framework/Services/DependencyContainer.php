<?php

namespace Framework\Services;

use League\Container\Exception\ContainerException;
use League\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class DependencyContainer implements ContainerInterface
{

    private array $instanceStotage = [];

    public function __construct(
        /** @var array<class-string, callback(ContainerInterface): mixed> */
        private array $factories
    ) {
    }

    public function has(string $id): bool
    {
        return isset($this->factories[$id]);
    }

    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            if (!isset($id, $this->instanceStotage[$id])) {
                $this->instanceStotage[$id] = $this->factories[$id]($this);
            }

            return $this->instanceStotage[$id] ?: throw new ContainerException("Error while retrieving the service '$id'");
        } else {
            throw new NotFoundException("Service '$id' not found in DependencyContainer");
        }
    }
}
