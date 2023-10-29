<?php

namespace Framework\Services;

use Psr\Container\ContainerInterface;

class DependencyContainer implements ContainerInterface
{
    private array $objects = [];

    public function __construct(
        /** @var array<class-string, callback(ContainerInterface): mixed> */
        private array $factories
    )
    {
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    // @TODO отдавал единый экземпляр
    public function get(string $id): mixed
    {
        // @TODO обрабатывать несуществующие id - будет выбрашено Error
        if (array_key_exists($id, $this->objects)) {
            //            var_dump($id);
            return $this->objects[$id]();
        } else {
            throw new \Exception("'$id' not exist in DependencyContainer");
        }
    }
}
