<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\ApiRequestSenderInterface;
use ChristianBrown\ApiClient\RequestContext;
use ChristianBrown\ApiClient\Transformer\JsonToArrayTransformerInterface;

use function str_replace;

final class DriverPackageUploader implements DriverPackageUploaderInterface
{
    private ApiHostInterface $apiHost;
    private ApiRequestSenderInterface $requestSender;
    private JsonToArrayTransformerInterface $responseTransformer;

    public function __construct(ApiRequestSenderInterface $requestSender, JsonToArrayTransformerInterface $responseTransformer, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->responseTransformer = $responseTransformer;
        $this->apiHost = $apiHost;
    }

    /**
     * @param string                $requestUrl     The request URL
     * @param array<string, string> $requestHeaders The request headers
     * @param string                $contents       The zip archive to send as the request body
     *
     * @return array<array-key, mixed>
     */
    public function upload(string $requestUrl, array $requestHeaders, string $contents): array
    {
        $url = str_replace(ApiHostInterface::PRODUCTION_BASE_URL, $this->apiHost->getBaseUrl(), $requestUrl);
        $headers = $requestHeaders + [ApiRequestSenderInterface::HEADER_CONTENT_TYPE => self::CONTENT_TYPE_ZIP];
        $body = $this->requestSender->post($url, [], $headers, $contents);

        return $this->responseTransformer->transform($body, new RequestContext(ApiRequestSenderInterface::METHOD_POST, $url));
    }
}
