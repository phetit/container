<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Tests;

use Phetit\DependencyInjection\ContainerBuilder;
use Phetit\DependencyInjection\Tests\Fixtures\Service;
use Phetit\DependencyInjection\Tests\Fixtures\ConstructorWithOptionalArgumentsService;
use Phetit\DependencyInjection\Tests\Fixtures\ConstructorWithMandatoryArgumentsService;
use Phetit\DependencyInjection\Tests\Fixtures\ConstructorWithNullableArgumentsService;
use Phetit\DependencyInjection\Tests\Fixtures\NoConstructorService;
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

    public function testClassResolution(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(Service::class);

        self::assertInstanceOf(Service::class, $service);
    }

    public function testClassResolutionWitNoConstructor(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(NoConstructorService::class);

        self::assertInstanceOf(NoConstructorService::class, $service);
    }

    public function testClassResolutionWithMandatoryArguments(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ConstructorWithMandatoryArgumentsService::class);

        self::assertInstanceOf(ConstructorWithMandatoryArgumentsService::class, $service);
    }

    public function testClassResolutionWithNullableArguments(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ConstructorWithNullableArgumentsService::class);

        self::assertInstanceOf(ConstructorWithNullableArgumentsService::class, $service);
        self::assertNull($service->service);
    }

    public function testClassResolutionWithOptionalArguments(): void
    {
        $builder = new ContainerBuilder();

        $service = $builder->get(ConstructorWithOptionalArgumentsService::class);

        self::assertInstanceOf(ConstructorWithOptionalArgumentsService::class, $service);
        self::assertInstanceOf(NoConstructorService::class, $service->service);
    }
}
