<?php

declare(strict_types=1);

namespace Phetit\Container;

use Phetit\Container\Exception\EntryNotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * The container's entries
     *
     * @var callable[]
     */
    protected array $entries = [];

    /**
     * The container's parameters
     *
     * @var mixed[]
     */
    protected array $parameters = [];

    public function register(string $id, callable $resolver): void
    {
        $this->entries[$id] = $resolver;
    }

    public function has(string $id): bool
    {
        return isset($this->parameters[$id]) || isset($this->entries[$id]);
    }

    public function get(string $id): mixed
    {
        if (isset($this->parameters[$id])) {
            return $this->parameters[$id];
        }

        if (isset($this->entries[$id])) {
            return $this->entries[$id]();
        }

        throw new EntryNotFoundException();
    }
    public function parameter(string $id, mixed $value): void
    {
        $this->parameters[$id] = $value;
    }
}
