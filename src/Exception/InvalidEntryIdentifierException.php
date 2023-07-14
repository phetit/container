<?php

declare(strict_types=1);

namespace Phetit\Container\Exception;

use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;

/**
 * This exception is thrown when a invalid entry identifier has been passed.
 */
class InvalidEntryIdentifierException extends InvalidArgumentException implements ContainerExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Invalid entry identifier "%s".', $id));
    }
}
