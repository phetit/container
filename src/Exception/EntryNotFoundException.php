<?php

declare(strict_types=1);

namespace Phetit\Container\Exception;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
