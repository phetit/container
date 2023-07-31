<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection;

use Phetit\DependencyInjection\Exception\DuplicateEntryIdentifierException;
use Phetit\DependencyInjection\Exception\EntryNotFoundException;
use Phetit\DependencyInjection\Exception\InvalidEntryIdentifierException;
use Phetit\DependencyInjection\Resolver\ResolverInterface;
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
     * @var ResolverInterface[]
     */
    protected array $services = [];

    public function has(string $id): bool
    {
        return $this->hasParameter($id) || $this->hasService($id);
    }

    public function get(string $id): mixed
    {
        if ($this->hasParameter($id)) {
            return $this->parameters[$id];
        }

        if ($this->hasService($id)) {
            return $this->services[$id]->resolve($this);
        }

        throw new EntryNotFoundException();
    }

    /**
     * Register a parameter to the container
     *
     * @param string $id Parameter identifier
     * @param mixed $value Parameter value
     *
     * @throws DuplicateEntryIdentifierException when a service exists with the same $id
     */
    public function parameter(string $id, mixed $value): void
    {
        $this->validateIdentifier($id);

        if ($this->hasService($id)) {
            throw new DuplicateEntryIdentifierException($id);
        }

        $this->parameters[$id] = $value;
    }

    /**
     * Register a service entry to the container
     *
     * @param string $id Entry identifier
     * @param ResolverInterface $resolver The service resolver
     *
     * @throws DuplicateEntryIdentifierException when a parameter exists with the same $id
     */
    public function set(string $id, ResolverInterface $resolver): void
    {
        $this->validateIdentifier($id);

        if ($this->hasParameter($id)) {
            throw new DuplicateEntryIdentifierException($id);
        }

        $this->services[$id] = $resolver;
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
}
