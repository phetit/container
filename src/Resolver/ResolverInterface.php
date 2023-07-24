<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Resolver;

use Phetit\DependencyInjection\Container;

interface ResolverInterface
{
    public function resolve(Container $container): mixed;
}
