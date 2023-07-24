<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Resolver;

use Phetit\DependencyInjection\Container;
use Phetit\DependencyInjection\Resolver\FactoryServiceResolver;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use PHPUnit\Framework\TestCase;

class FactoryServiceResolverTest extends TestCase
{
    public function testResolvesCorrectly(): void
    {
        $service = new FactoryServiceResolver(fn () => 'bar');

        self::assertSame('bar', $service->resolve(new Container()));
    }

    public function testShouldResolveTheDifferentInstance(): void
    {
        $container = new Container();
        $service = new FactoryServiceResolver(fn () => new Service());

        $instanceOne = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceOne);

        $instanceTwo = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceTwo);

        self::assertNotSame($instanceOne, $instanceTwo);
    }

    public function testShouldPassContainerToCallback(): void
    {
        $container = new Container();
        $container->parameter('foo', 'factory-service-resolver');

        $service = new FactoryServiceResolver(fn (Container $c) => $c->get('foo'));

        self::assertSame('factory-service-resolver', $service->resolve($container));
    }
}
