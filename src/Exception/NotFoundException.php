<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Exception;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Base NotFoundException for Container component.
 */
class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
