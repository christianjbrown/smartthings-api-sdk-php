<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class CapabilityApi implements CapabilityApiInterface
{
    /**
     * @var array<string, CapabilityInterface>
     */
    private array $cache = [];
    private CapabilitiesTransformerInterface $capabilitiesTransformer;
    private CapabilityTransformerInterface $capabilityTransformer;

    /**
     * @var ?array<int, CapabilityInterface>
     */
    private ?array $listCache = null;

    /**
     * @var array<string, array<int, CapabilityInterface>>
     */
    private array $namespaceCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, CapabilityTransformerInterface $capabilityTransformer, CapabilitiesTransformerInterface $capabilitiesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->capabilityTransformer = $capabilityTransformer;
        $this->capabilitiesTransformer = $capabilitiesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    public function getMultiple(bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (null !== $this->listCache) {
                return $this->listCache;
            }
        }

        $capabilities = $this->fetchList(self::API_URL);
        $this->listCache = $capabilities;

        return $capabilities;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    public function getMultipleByNamespace(string $namespace, bool $skipCache = false): array
    {
        if (!$skipCache) {
            if (isset($this->namespaceCache[$namespace])) {
                return $this->namespaceCache[$namespace];
            }
        }

        $url = sprintf(self::API_URL_NAMESPACE_SPRINTF, rawurlencode($namespace));
        $capabilities = $this->fetchList($url);
        $this->namespaceCache[$namespace] = $capabilities;

        return $capabilities;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByIdAndVersion(string $capabilityId, int $version, bool $skipCache = false): CapabilityInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $capabilityId, $version);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($capabilityId), $version);
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $capability = $this->capabilityTransformer->transform($data);
        $this->cache[$cacheKey] = $capability;

        return $capability;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, CapabilityInterface>
     */
    private function fetchList(string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }

        return $this->capabilitiesTransformer->transform($data[self::KEY_ITEMS]);
    }
}
