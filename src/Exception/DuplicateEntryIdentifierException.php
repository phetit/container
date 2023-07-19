<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Exception;

use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;

/**
 * This exception is thrown when a already registered entry identifier has been passed.
 */
class DuplicateEntryIdentifierException extends InvalidArgumentException implements ContainerExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Duplicate entry identifier "%s".', $id));
    }
}
