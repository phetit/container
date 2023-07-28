<?php

declare(strict_types=1);

namespace Phetit\DependencyInjection\Exception\Dependency;

use Phetit\DependencyInjection\Exception\ContainerException;

/**
 * This exception is thrown when a class's dependency fails to be resolved because invalid type
 */
abstract class AbstractTypeException extends ContainerException
{
    protected string $formatMessage = 'Failed to resolve class "%s" because invalid type for parameter "%s"';

    /**
     * @param string $class Class trying to be resolved
     * @param string $parameter Dependency trying to be resolved
     */
    public function __construct(string $class, string $parameter)
    {
        parent::__construct(sprintf($this->formatMessage, $class, $parameter));
    }
}
