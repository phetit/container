<?php

declare(strict_types=1);

namespace Phetit\Container\Exception;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Base NotFoundException for Container component.
 */
class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
