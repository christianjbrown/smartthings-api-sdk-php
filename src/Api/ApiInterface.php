<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

interface ApiInterface
{
    public const string HEADER_KEY_ACCEPT_LANGUAGE = 'Accept-Language';
    public const string HEADER_KEY_AUTHORIZATION = 'Authorization';
    public const string HEADER_KEY_IF_NONE_MATCH = 'If-None-Match';
    public const string HEADER_KEY_ORGANIZATION = 'X-ST-Organization';
    public const string HEADER_KEY_ORGANIZATION_ID = 'X-ST-Organization';
}
