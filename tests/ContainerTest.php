<?php

declare(strict_types=1);

namespace Phetit\Container\Tests;

use Phetit\Container\Container;
use Phetit\Container\Exception\EntryNotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testHasReturnsFalseOnMissingEntry(): void
    {
        $container = new Container();

        $hasEntry = $container->has('foo');

        self::assertFalse($hasEntry);
    }

    public function testHasReturnsTrueOnRegisteredEntry(): void
    {
        $container = new Container();

        $container->register('foo', fn() => 'bar');
        $hasEntry = $container->has('foo');

        self::assertTrue($hasEntry);
    }

    public function testResolvesClosureEntry(): void
    {
        $container = new Container();

        $container->register('foo', fn() => 'bar');

        $resolve = $container->get('foo');

        self::assertEquals('bar', $resolve);
    }

    public function testThrowsExceptionWhenTryingToResolveMissingEntry(): void
    {

        $container = new Container();

        self::expectExceptionObject(new EntryNotFoundException());

        $container->get('foo');
    }
}
