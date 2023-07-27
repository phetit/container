<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests;

use Phetit\DependencyInjection\ContainerBuilder;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use Phetit\DependencyInjection\Tests\Fixtures\ServiceWithDefaultValue;
use Phetit\DependencyInjection\Tests\Fixtures\ServiceWithDependency;
use Phetit\DependencyInjection\Tests\Fixtures\ServiceWithNullableDependency;
use Phetit\DependencyInjection\Tests\Fixtures\ServiceWithoutConstructor;
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

    public function testDynamicClassResolution(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(Service::class);

        self::assertInstanceOf(Service::class, $service);
    }

    public function testDynamicClassResolutionWithoutConstructor(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ServiceWithoutConstructor::class);

        self::assertInstanceOf(ServiceWithoutConstructor::class, $service);
    }

    public function testDynamicClassResolutionWithDependency(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ServiceWithDependency::class);

        self::assertInstanceOf(ServiceWithDependency::class, $service);
    }

    public function testDynamicClassResolutionWithNullableDependency(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ServiceWithNullableDependency::class);

        self::assertInstanceOf(ServiceWithNullableDependency::class, $service);
        self::assertNull($service->service);
    }

    public function testDynamicClassResolutionWithDefaultValue(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ServiceWithDefaultValue::class);

        self::assertInstanceOf(ServiceWithDefaultValue::class, $service);
        self::assertInstanceOf(ServiceWithoutConstructor::class, $service->service);
    }
}
