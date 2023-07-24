<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Resolver;

use Closure;
use Phetit\DependencyInjection\Container;

class ServiceResolver implements ResolverInterface
{
    protected mixed $instance = null;

    public function __construct(protected Closure $callback)
    {
    }

    public function resolve(Container $container): mixed
    {
        if (is_null($this->instance)) {
            $this->instance = ($this->callback)($container);
        }

        return $this->instance;
    }
}
