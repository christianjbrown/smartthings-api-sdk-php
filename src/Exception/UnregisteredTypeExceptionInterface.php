<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Exception;

/**
 * Thrown when a registry is asked for a type nothing was registered for: a wiring mistake, not bad input.
 */
interface UnregisteredTypeExceptionInterface extends ExceptionInterface
{
}
