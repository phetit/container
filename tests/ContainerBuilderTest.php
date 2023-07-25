<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests;

use Phetit\DependencyInjection\ContainerBuilder;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ContainerBuilderTest extends TestCase
{
    public function testRegisterMethodShouldAddServiceResolver(): void
    {
        $builder = new ContainerBuilder();

        $builder->register('foo', fn() => new Service());

        $serviceOne = $builder->get('foo');
        self::assertInstanceOf(Service::class, $serviceOne);

        $serviceTwo = $builder->get('foo');
        self::assertInstanceOf(Service::class, $serviceTwo);

        self::assertSame($serviceOne, $serviceTwo);
    }

    public function testFactoryMethodShouldAddFactoryServiceResolver(): void
    {
        $builder = new ContainerBuilder();

        $builder->factory('foo', fn() => new Service());

        $serviceOne = $builder->get('foo');
        self::assertInstanceOf(Service::class, $serviceOne);

        $serviceTwo = $builder->get('foo');
        self::assertInstanceOf(Service::class, $serviceTwo);

        self::assertNotSame($serviceOne, $serviceTwo);
    }

    public function testShouldInjectAutoReference(): void
    {
        $builder = new ContainerBuilder();

        $container = $builder->get(ContainerInterface::class);

        self::assertInstanceOf(ContainerBuilder::class, $container);
        self::assertSame($builder, $container);
    }
}
