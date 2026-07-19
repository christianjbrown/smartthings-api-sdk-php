<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

interface TokenInterface
{
    public const string AUTHORIZATION_HEADER_VALUE_SPRINTF = 'Bearer %s';

    public function toAuthorizationHeaderValue(): string;
}
