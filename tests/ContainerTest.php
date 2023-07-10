<?php

declare(strict_types=1);

namespace Phetit\Container\Tests;

use Phetit\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainerResolvesClosureEntry(): void
    {
        $container = new Container();

        $container->register('foo', fn() => 'bar');

        $resolve = $container->get('foo');

        self::assertEquals('bar', $resolve);
    }
}
