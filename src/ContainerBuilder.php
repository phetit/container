<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection;

use Closure;
use Phetit\DependencyInjection\Resolver\FactoryServiceResolver;
use Phetit\DependencyInjection\Resolver\ServiceResolver;

class ContainerBuilder extends Container
{
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
}
