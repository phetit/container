<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Resolver;

use Phetit\DependencyInjection\Container;
use Phetit\DependencyInjection\Resolver\ServiceResolver;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use PHPUnit\Framework\TestCase;

class ServiceResolverTest extends TestCase
{
    public function testResolvesCorrectly(): void
    {
        $service = new ServiceResolver(fn() => 'bar');

        self::assertSame('bar', $service->resolve(new Container()));
    }

    public function testShouldResolveTheSameInstance(): void
    {
        $container = new Container();
        $service = new ServiceResolver(fn() => new Service());

        $instanceOne = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceOne);

        $instanceTwo = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceTwo);

        self::assertSame($instanceOne, $instanceTwo);
    }

    public function testShouldPassContainerToCallback(): void
    {
        $container = new Container();
        $container->parameter('foo', 'service-resolver');

        $service = new ServiceResolver(fn(Container $c) => $c->get('foo'));

        self::assertSame('service-resolver', $service->resolve($container));
    }
}
