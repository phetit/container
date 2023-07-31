<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Fixtures;

class ConstructorWithOptionalArgumentsService
{
    public function __construct(
        public Service $service = new NoConstructorService(),
        public int $value = 0,
    ) {
    }
}
