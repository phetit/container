<?php

declare(strict_types=1);

namespace Phetit\Container;

use Phetit\Container\Exception\EntryNotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * The container's services
     *
     * @var callable[]
     */
    protected array $services = [];

    /**
     * The container's parameters
     *
     * @var mixed[]
     */
    protected array $parameters = [];

    public function register(string $id, callable $resolver): void
    {
        $this->services[$id] = $resolver;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->parameters) || isset($this->services[$id]);
    }

    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->parameters)) {
            return $this->parameters[$id];
        }

        if (isset($this->services[$id])) {
            return $this->services[$id]();
        }

        throw new EntryNotFoundException();
    }
    public function parameter(string $id, mixed $value): void
    {
        $this->parameters[$id] = $value;
    }
}
