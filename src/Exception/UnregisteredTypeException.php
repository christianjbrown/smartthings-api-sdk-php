<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Exception;

use LogicException;

final class UnregisteredTypeException extends LogicException implements UnregisteredTypeExceptionInterface
{
}
