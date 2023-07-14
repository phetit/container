<?php

declare(strict_types=1);

namespace Phetit\Container;

use Phetit\Container\Exception\EntryNotFoundException;
use Phetit\Container\Exception\InvalidEntryIdentifierException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * The container's parameters
     *
     * @var mixed[]
     */
    protected array $parameters = [];

    /**
     * The container's services
     *
     * @var callable[]
     */
    protected array $services = [];

    /**
     * The container's factories
     *
     * @var callable[]
     */
    protected array $factories = [];

    public function has(string $id): bool
    {
        return $this->hasParameter($id) || $this->hasService($id) || $this->hasFactory($id);
    }

    public function get(string $id): mixed
    {
        if ($this->hasParameter($id)) {
            return $this->parameters[$id];
        }

        if ($this->hasService($id)) {
            $this->parameters[$id] = $this->services[$id]($this);

            return $this->parameters[$id];
        }

        if ($this->hasFactory($id)) {
            return $this->factories[$id]($this);
        }

        throw new EntryNotFoundException();
    }

    /**
     * Register parameters that returns the value set
     */
    public function parameter(string $id, mixed $value): void
    {
        $this->validateIdentifier($id);

        $this->parameters[$id] = $value;
    }

    /**
     * Register a service that is resolved only the first time `get()` is called
     */
    public function register(string $id, callable $resolver): void
    {
        $this->validateIdentifier($id);

        $this->services[$id] = $resolver;
    }

    /**
     * Register a service that is resolved in every call to `get()` method
     */
    public function factory(string $id, callable $resolver): void
    {
        $this->validateIdentifier($id);

        $this->factories[$id] = $resolver;
    }

    /**
     * Validate entry identifier
     *
     * @throws InvalidEntryIdentifierException if $id is an empty string.
     */
    protected function validateIdentifier(string $id): void
    {
        if ($id === '') {
            throw new InvalidEntryIdentifierException($id);
        }
    }

    /**
     * Returns true is a parameter exists under the given identifier.
     */
    public function hasParameter(string $id): bool
    {
        return array_key_exists($id, $this->parameters);
    }

    /**
     * Returns true is a service exists under the given identifier.
     */
    public function hasService(string $id): bool
    {
        return isset($this->services[$id]);
    }

    /**
     * Returns true is a static service exists under the given identifier.
     */
    public function hasFactory(string $id): bool
    {
        return isset($this->factories[$id]);
    }
}
