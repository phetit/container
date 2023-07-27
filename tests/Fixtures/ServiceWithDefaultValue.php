<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Fixtures;

class ServiceWithDefaultValue
{
    public function __construct(
        public Service $service = new ServiceWithoutConstructor(),
        public int $value = 0,
    ) {
    }
}
