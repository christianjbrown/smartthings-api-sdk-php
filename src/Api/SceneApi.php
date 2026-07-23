<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SceneInterface;
use ChristianBrown\SmartThings\Transformer\ScenesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SceneTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class SceneApi implements SceneApiInterface
{
    /**
     * @var array<string, SceneInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, array<int, SceneInterface>>
     */
    private array $listCache = [];
    private JsonApiRequestSenderInterface $requestSender;
    private ScenesTransformerInterface $scenesTransformer;
    private SceneTransformerInterface $sceneTransformer;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, SceneTransformerInterface $sceneTransformer, ScenesTransformerInterface $scenesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->sceneTransformer = $sceneTransformer;
        $this->scenesTransformer = $scenesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, SceneInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array
    {
        // Cache per location; casting keeps null and a real id as distinct
        // string keys without adding a null-coalescing branch to this method.
        $cacheKey = (string) $locationId;
        if (!$skipCache) {
            if (isset($this->listCache[$cacheKey])) {
                return $this->listCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get(self::API_URL, self::buildQuery($locationId), $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $scenes = $this->scenesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$cacheKey] = $scenes;

        return $scenes;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $sceneId, bool $skipCache = false): SceneInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$sceneId])) {
                return $this->cache[$sceneId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($sceneId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $scene = $this->sceneTransformer->transform($data);
        $this->cache[$sceneId] = $scene;

        return $scene;
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?string $locationId): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the cache and response-shape guards in getMultiple().
        if (null === $locationId) {
            return [];
        }

        return [self::KEY_LOCATION_ID => $locationId];
    }
}
