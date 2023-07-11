# Phetit Container
A simple PHP dependency injection container.

This package is an implementation of [PSR-11](https://www.php-fig.org/psr/psr-11/) container interface.

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
// $foo === 'bar'
$foo = $container->get('foo');
```
## Contributing

Refer to [CONTRIBUTING](./CONTRIBUTING.md) for information.

## License

[MIT](https://github.com/phetit/container/blob/main/LICENSE)
