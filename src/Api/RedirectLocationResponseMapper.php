<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function json_encode;

use const JSON_THROW_ON_ERROR;

final class RedirectLocationResponseMapper implements RedirectLocationResponseMapperInterface
{
    public function __invoke(ResponseInterface $response): ResponseInterface
    {
        if (!$response->hasHeader(self::HEADER_LOCATION)) {
            return $response;
        }

        return new Response(self::STATUS_OK, [], json_encode([self::KEY_LOCATION => $response->getHeaderLine(self::HEADER_LOCATION)], JSON_THROW_ON_ERROR));
    }
}
