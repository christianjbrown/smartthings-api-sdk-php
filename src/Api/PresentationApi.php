<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PresentationInterface;
use ChristianBrown\SmartThings\Transformer\PresentationTransformerInterface;

use function rawurlencode;
use function sprintf;

final class PresentationApi implements PresentationApiInterface
{
    /**
     * @var array<string, PresentationInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, PresentationInterface>
     */
    private array $deviceConfigCache = [];
    private PresentationTransformerInterface $presentationTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    /**
     * @var array<string, PresentationInterface>
     */
    private array $typeCache = [];

    public function __construct(JsonApiRequestSenderInterface $requestSender, PresentationTransformerInterface $presentationTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->presentationTransformer = $presentationTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDeviceConfig(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $presentationId, (string) $manufacturerName);
        if (!$skipCache) {
            if (isset($this->deviceConfigCache[$cacheKey])) {
                return $this->deviceConfigCache[$cacheKey];
            }
        }

        $presentation = $this->fetch(self::buildQuery($presentationId, $manufacturerName), self::API_URL_DEVICE_CONFIG);
        $this->deviceConfigCache[$cacheKey] = $presentation;

        return $presentation;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getDeviceConfigByType(string $typeIntegrationId, bool $skipCache = false): PresentationInterface
    {
        if (!$skipCache) {
            if (isset($this->typeCache[$typeIntegrationId])) {
                return $this->typeCache[$typeIntegrationId];
            }
        }

        $url = sprintf(self::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, rawurlencode($typeIntegrationId));
        $presentation = $this->fetch([], $url);
        $this->typeCache[$typeIntegrationId] = $presentation;

        return $presentation;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOne(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_SPRINTF, $presentationId, (string) $manufacturerName);
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
            }
        }

        $presentation = $this->fetch(self::buildQuery($presentationId, $manufacturerName), self::API_URL);
        $this->cache[$cacheKey] = $presentation;

        return $presentation;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(string $presentationId, ?string $manufacturerName): array
    {
        // The manufacturerName filter is optional, so it is only added when set.
        $query = [self::KEY_PRESENTATION_ID => $presentationId];
        if (null !== $manufacturerName) {
            $query[self::KEY_MANUFACTURER_NAME] = $manufacturerName;
        }

        return $query;
    }

    /**
     * @param array<string, string> $query
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    private function fetch(array $query, string $url): PresentationInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, $query, $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->presentationTransformer->transform($data);
    }
}
