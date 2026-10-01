<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Multipart\MultipartPartInterface;

use function str_replace;

final class HostOverridingJsonApiRequestSender implements JsonApiRequestSenderInterface
{
    private ApiHostInterface $apiHost;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ApiHostInterface $apiHost)
    {
        $this->requestSender = $requestSender;
        $this->apiHost = $apiHost;
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     *
     * @return array<array-key, mixed>
     */
    public function delete(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = []): array
    {
        return $this->requestSender->delete($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     *
     * @return array<array-key, mixed>
     */
    public function get(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = []): array
    {
        return $this->requestSender->get($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function patch(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->patch($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function patchForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->patchForm($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function patchMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->patchMultipart($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function post(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->post($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function postForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->postForm($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function postMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->postMultipart($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    /**
     * @param string                       $requestUrl          The request URL
     * @param array<string, string>        $requestQueryStrings
     * @param array<string, string>        $requestHeaders
     * @param null|array<array-key, mixed> $requestBodyArray
     *
     * @return array<array-key, mixed>
     */
    public function put(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], ?array $requestBodyArray = null): array
    {
        return $this->requestSender->put($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyArray);
    }

    /**
     * @param string                $requestUrl          The request URL
     * @param array<string, string> $requestQueryStrings
     * @param array<string, string> $requestHeaders
     * @param array<string, string> $requestBodyFormData
     *
     * @return array<array-key, mixed>
     */
    public function putForm(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyFormData = []): array
    {
        return $this->requestSender->putForm($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyFormData);
    }

    /**
     * @param string                             $requestUrl          The request URL
     * @param array<string, string>              $requestQueryStrings
     * @param array<string, string>              $requestHeaders
     * @param array<int, MultipartPartInterface> $requestBodyParts
     *
     * @return array<array-key, mixed>
     */
    public function putMultipart(string $requestUrl, array $requestQueryStrings = [], array $requestHeaders = [], array $requestBodyParts = []): array
    {
        return $this->requestSender->putMultipart($this->rewriteHost($requestUrl), $requestQueryStrings, $requestHeaders, $requestBodyParts);
    }

    private function rewriteHost(string $requestUrl): string
    {
        return str_replace(ApiHostInterface::PRODUCTION_BASE_URL, $this->apiHost->getBaseUrl(), $requestUrl);
    }
}
