<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use function sprintf;

final class Token implements TokenInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toAuthorizationHeaderValue(): string
    {
        return sprintf(self::AUTHORIZATION_HEADER_VALUE_SPRINTF, $this->value);
    }
}
