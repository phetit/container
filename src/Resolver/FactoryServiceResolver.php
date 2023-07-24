<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Resolver;

use Closure;
use Phetit\DependencyInjection\Container;

class FactoryServiceResolver implements ResolverInterface
{
    public function __construct(protected Closure $callback)
    {
    }

    public function resolve(Container $container): mixed
    {
        return ($this->callback)($container);
    }
}
