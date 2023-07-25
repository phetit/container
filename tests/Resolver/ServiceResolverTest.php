<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests\Resolver;

use Phetit\DependencyInjection\Container;
use Phetit\DependencyInjection\Resolver\ServiceResolver;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ServiceResolverTest extends TestCase
{
    public function testResolvesCorrectly(): void
    {
        $container = $this->createMock(Container::class);
        $service = new ServiceResolver(fn() => 'bar');

        self::assertSame('bar', $service->resolve($container));
    }

    public function testShouldResolveTheSameInstance(): void
    {
        $container = $this->createMock(Container::class);
        $service = new ServiceResolver(fn() => new Service());

        $instanceOne = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceOne);

        $instanceTwo = $service->resolve($container);
        self::assertInstanceOf(Service::class, $instanceTwo);

        self::assertSame($instanceOne, $instanceTwo);
    }

    public function testShouldPassContainerToCallback(): void
    {
        /** @var Container&MockObject */
        $container = $this->createMock(Container::class);
        $container->expects(self::once())
            ->method('get')
            ->with(self::identicalTo('foo'))
            ->willReturn('service-resolver');

        $service = new ServiceResolver(fn(Container $c) => $c->get('foo'));

        self::assertSame('service-resolver', $service->resolve($container));
    }
}
