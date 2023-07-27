<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection;

use Closure;
use Phetit\DependencyInjection\Exception\Dependency\InvalidBuiltinTypeException;
use Phetit\DependencyInjection\Exception\Dependency\InvalidIntersectionTypeException;
use Phetit\DependencyInjection\Exception\Dependency\InvalidMissingTypeException;
use Phetit\DependencyInjection\Exception\Dependency\InvalidUnionTypeException;
use Phetit\DependencyInjection\Exception\EntryNotFoundException;
use Phetit\DependencyInjection\Resolver\FactoryServiceResolver;
use Phetit\DependencyInjection\Resolver\ServiceResolver;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class ContainerBuilder extends Container
{
    public function __construct()
    {
        $this->parameter(ContainerInterface::class, $this);
    }

    public function register(string $id, Closure $resolver): static
    {
        $this->set($id, new ServiceResolver($resolver));

        return $this;
    }

    public function factory(string $id, Closure $resolver): static
    {
        $this->set($id, new FactoryServiceResolver($resolver));

        return $this;
    }

    public function has(string $id): bool
    {
        if (parent::has($id)) {
            return true;
        }

        return $this->isResolvable($id);
    }

    public function get(string $id): mixed
    {
        if (! $this->has($id)) {
            throw new EntryNotFoundException();
        }

        if (parent::has($id)) {
            return parent::get($id);
        }

        return $this->resolveClass($id);
    }

    protected function resolveClass(string $id): mixed
    {
        $reflectionClass = new ReflectionClass($id);

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        $parameters = $constructor->getParameters();

        if (count($parameters) === 0) {
            return $reflectionClass->newInstance();
        }

        $dependencies = $this->resolveDependencies($id, $parameters);

        return $reflectionClass->newInstance(...$dependencies);
    }

    /**
     * Resolves dynamic class dependencies
     *
     * @param string $id Class identifier
     * @param ReflectionParameter[] $parameters
     *
     * @return mixed[]
     */
    protected function resolveDependencies(string $id, array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencies[] = $this->resolveDependency($id, $parameter);
        }

        return $dependencies;
    }

    /**
     * Resolves dynamic class dependency
     *
     * @param string $id Class identifier
     * @param ReflectionParameter $parameter
     *
     * @return mixed
     */
    protected function resolveDependency(string $id, ReflectionParameter $parameter): mixed
    {
        $type = $parameter->getType();

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if (! $parameter->hasType()) {
            throw new InvalidMissingTypeException($id, $parameter->name);
        }

        if ($parameter->allowsNull()) {
            return null;
        }

        if ($type instanceof ReflectionUnionType) {
            throw new InvalidUnionTypeException($id, $parameter->name);
        }

        if ($type instanceof ReflectionIntersectionType) {
            throw new InvalidIntersectionTypeException($id, $parameter->name);
        }

        if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
            throw new InvalidBuiltinTypeException($id, $parameter->name);
        }

        return $this->get($type->getName());
    }

    protected function isResolvable(string $id): bool
    {
        try {
            $class = new ReflectionClass($id);
        } catch (ReflectionException) {
            return false;
        }

        return $class->isInstantiable();
    }
}
