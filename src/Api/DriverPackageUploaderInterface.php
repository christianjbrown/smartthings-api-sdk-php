<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;

interface DriverPackageUploaderInterface
{
    public const string CONTENT_TYPE_ZIP = 'application/zip';

    /**
     * Posts a zip archive as the raw request body and decodes the JSON response.
     *
     * @param string                $requestUrl     The request URL
     * @param array<string, string> $requestHeaders The request headers
     * @param string                $contents       The zip archive to send as the request body
     *
     * @throws RequestExceptionInterface
     *
     * @return array<array-key, mixed>
     */
    public function upload(string $requestUrl, array $requestHeaders, string $contents): array;
}
