<?php

declare(strict_types=1);

namespace Phetit\Container\Exception;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

/**
 * Base ContainerException for Container component.
 */
class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
