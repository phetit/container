<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Resolver;

use Phetit\DependencyInjection\Container;
use Phetit\DependencyInjection\Resolver\FactoryServiceResolver;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FactoryServiceResolverTest extends TestCase
{
    public function testResolvesCorrectly(): void
    {
        $container = $this->createMock(Container::class);
        $service = new FactoryServiceResolver(fn () => 'bar');

        self::assertSame('bar', $service->resolve($container));
    }

    public function testShouldResolveTheDifferentInstance(): void
    {
        $container = $this->createMock(Container::class);
        $service = new FactoryServiceResolver(fn () => new Service());

        $instanceOne = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceOne);

        $instanceTwo = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceTwo);

        self::assertNotSame($instanceOne, $instanceTwo);
    }

    public function testShouldPassContainerToCallback(): void
    {
        /** @var Container&MockObject */
        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('get')
            ->with(self::identicalTo('foo'))
            ->willReturn('factory-service-resolver');

        $service = new FactoryServiceResolver(fn (Container $c) => $c->get('foo'));

        self::assertSame('factory-service-resolver', $service->resolve($container));
    }
}
