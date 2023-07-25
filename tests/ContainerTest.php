<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests;

use Closure;
use Phetit\DependencyInjection\Container;
use Phetit\DependencyInjection\Exception\DuplicateEntryIdentifierException;
use Phetit\DependencyInjection\Exception\EntryNotFoundException;
use Phetit\DependencyInjection\Exception\InvalidEntryIdentifierException;
use Phetit\DependencyInjection\Resolver\ResolverInterface;
use PHPUnit\Framework\MockObject\MockObject;
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

        $container->parameter('foo', 'bar');
        self::assertTrue($container->has('foo'));

        $container->set('service', $this->createMock(ResolverInterface::class));
        self::assertTrue($container->has('service'));
    }

    public function testShouldCallResolveMethodInResolverPassingSelfReference(): void
    {
        $container = new Container();
        $container->parameter('bar', 45);

        /** @var ResolverInterface&MockObject */
        $service = $this->createMock(ResolverInterface::class);
        $service->expects(self::once())
            ->method('resolve')
            ->with(self::isInstanceOf(Container::class));

        $container->set('foo', $service);
        $container->get('foo');
    }

    public function testThrowsExceptionWhenTryingToResolveMissingEntry(): void
    {

        $container = new Container();

        self::expectExceptionObject(new EntryNotFoundException());

        $container->get('foo');
    }

    public function testShouldSetParameters(): void
    {
        $container = new Container();

        $container->parameter('foo', 'bar');

        self::assertSame('bar', $container->get('foo'));
    }

    public function testParametersAreNotResolved(): void
    {
        $container = new Container();

        $container->parameter('foo', fn () => 'bazz');

        $foo = $container->get('foo');

        self::assertInstanceOf(Closure::class, $foo);
        self::assertSame('bazz', $foo());
    }

    public function testResolvesNullValueParameters(): void
    {
        $container = new Container();

        $container->parameter('foo', null);

        self::assertTrue($container->has('foo'));
        self::assertNull($container->get('foo'));
    }

    public function testExceptionShouldBeThrownRegisteringParameterWithEmptyId(): void
    {
        $container = new Container();

        self::expectException(InvalidEntryIdentifierException::class);
        $container->parameter('', 'empty');
    }

    public function testExceptionShouldBeThrownRegisteringServiceWithEmptyId(): void
    {
        $container = new Container();

        self::expectException(InvalidEntryIdentifierException::class);
        $container->set('', $this->createMock(ResolverInterface::class));
    }

    public function testExceptionShouldBeThrownWithDuplicateParameterId(): void
    {
        $container = new Container();

        $container->set('foo', $this->createMock(ResolverInterface::class));

        self::expectException(DuplicateEntryIdentifierException::class);
        $container->parameter('foo', 'bar');
    }

    public function testExceptionShouldBeThrownWithDuplicateServiceId(): void
    {
        $container = new Container();

        $container->parameter('foo', 'bar');

        self::expectException(DuplicateEntryIdentifierException::class);
        $container->set('foo', $this->createMock(ResolverInterface::class));
    }
}
