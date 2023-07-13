<?php

declare(strict_types=1);

namespace Phetit\Container\Tests;

use Phetit\Container\Container;
use Phetit\Container\Exception\EntryNotFoundException;
use Phetit\Container\Tests\Fixtures\Service;
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

    public function testServicesShouldBeDifferent(): void
    {
        $container = new Container();

        $container->register('service', fn() => new Service());

        $serviceOne = $container->get('service');
        self::assertInstanceOf(Service::class, $serviceOne);

        $serviceTwo = $container->get('service');
        self::assertInstanceOf(Service::class, $serviceTwo);

        self::assertNotSame($serviceOne, $serviceTwo);
    }

    public function testParameters(): void
    {
        $container = new Container();

        $container->parameter('foo', 'bar');

        self::assertSame('bar', $container->get('foo'));
    }

    public function testResolvesNullValueParameters(): void
    {
        $container = new Container();

        $container->parameter('foo', null);

        self::assertTrue($container->has('foo'));
        self::assertNull($container->get('foo'));
    }
}
