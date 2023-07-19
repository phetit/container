<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Fixtures;

class Service
{
    public function __construct(public int $value = 0)
    {
    }
}
