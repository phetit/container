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

    public function register(string $id, callable $resolver): void
    {
        $this->entries[$id] = $resolver;
    }

    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            return $this->entries[$id]();
        }

        throw new EntryNotFoundException();
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }
}
