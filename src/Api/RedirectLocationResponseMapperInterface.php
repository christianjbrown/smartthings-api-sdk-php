<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use Psr\Http\Message\ResponseInterface;

interface RedirectLocationResponseMapperInterface
{
    public const string HEADER_LOCATION = 'Location';
    public const string KEY_LOCATION = 'location';
    public const int STATUS_OK = 200;

    /**
     * Turns a response that carries a Location header into a 200 response whose JSON
     * body holds that address, so a redirect can be read through the JSON request
     * sender instead of being followed. Any other response is returned unchanged.
     */
    public function __invoke(ResponseInterface $response): ResponseInterface;
}
