<div align="center">

[![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/phetit/container?display_name=tag&sort=semver)](https://github.com/phetit/container/releases/latest)
[![Packagist](https://img.shields.io/packagist/v/phetit/container)](https://packagist.org/packages/phetit/container)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/phetit/container/php?color=6e71a4)
[![tests](https://github.com/phetit/container/actions/workflows/tests.yml/badge.svg)](https://github.com/phetit/container/actions/workflows/tests.yml?query=branch%3Amain)
[![GitHub](https://img.shields.io/github/license/phetit/container)](https://github.com/phetit/container/blob/main/LICENSE)

</div>

# Phetit Container
A simple PHP dependency injection container.

This package is an implementation of [PSR-11](https://www.php-fig.org/psr/psr-11/) container interface, and follows the [Semantic Versioning](https://semver.org/spec/v2.0.0.html) specification.

## Installation

You can install it using [composer](https://getcomposer.org/):

```bash
composer require phetit/container
```
## Usage

Create an instance of `Container` class.

```php
use Phetit\Container\Container;

$container = new Container();
```

### Register a service

You can register a service using the `register($id, $resolver)` method, and passing the `id` (string) and the `resolver` (a closure).

```php
$container->register('foo', fn() => 'bar');
```

### Retrieving the service

You can retrieve registered services using the `get($id)` method:

```php
$foo = $container->get('foo');
// $foo === 'bar'
```

### Static services

By default services are resolved every time you call `get($id)` method.

```php
$container->register('service' fn() => new Service());

$serviceOne = $container->get('service'); // Service object
$serviceTwo = $container->get('service'); // Service object

// $serviceOne === $serviceTwo => false
```

If you want to register a service that is resolved only the first time, you can do it using `static()` method:

```php
$container->static('service' fn() => new Service());

$serviceOne = $container->get('service'); // Service object
$serviceTwo = $container->get('service'); // Service object

// $serviceOne === $serviceTwo => true
```

### Parameters

You can register parameters using `parameter()` method:

```php
$container->parameter('foo', 'bar');
$container->parameter('func', fn() => new Service());

$container->get('foo'); // 'bar'

// Parameters are not resolved
$func = $container->get('func'); // $func = fn() => new Service()
$service = $func(); // 'Service object'
```

### Accessing container from a service

Container object is injected to service resolvers, so you can access other entries defined in the container:

```php
$container->parameter('db_dns', 'mysql:dbname=testdb;host=127.0.0.1');
$container->parameter('db_user', 'dbuser');
$container->parameter('db_pass', 'dbpass');

$container->register('db', fn(Container $c) => new PDO(
    $c->get('db_dns'),
    $c->get('db_user'),
    $c->get('db_pass'),
));
```

## Contributing

Refer to [CONTRIBUTING](./CONTRIBUTING.md) for information.

## License

[MIT](https://github.com/phetit/container/blob/main/LICENSE)
