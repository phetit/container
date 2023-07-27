<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Fixtures;

class ServiceWithDependency
{
    public function __construct(public Service $service)
    {
    }
}
