<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Exception\Dependency;

/**
 * This exception is thrown when a class's dependency fails to be resolved because missing type hint
 */
class InvalidMissingTypeException extends InvalidTypeException
{
    protected string $formatMessage = 'Failed to resolve class "%s" because parameter "%s" has no type hint';
}
