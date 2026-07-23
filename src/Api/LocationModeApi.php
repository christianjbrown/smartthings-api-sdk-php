<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class LocationModeApi implements LocationModeApiInterface
{
    /**
     * @var array<string, ModeInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, ModeInterface>
     */
    private array $currentCache = [];

    /**
     * @var array<string, array<int, ModeInterface>>
     */
    private array $listCache = [];
    private ModesTransformerInterface $modesTransformer;
    private ModeTransformerInterface $modeTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, ModeTransformerInterface $modeTransformer, ModesTransformerInterface $modesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->modeTransformer = $modeTransformer;
        $this->modesTransformer = $modesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCurrent(LocationInterface $location, bool $skipCache = false): ModeInterface
    {
        $locationId = $location->getLocationId();
        if (!$skipCache) {
            if (isset($this->currentCache[$locationId])) {
                return $this->currentCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CURRENT_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->currentCache[$locationId] = $mode;

        return $mode;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, ModeInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false): array
    {
        $locationId = $location->getLocationId();
        if (!$skipCache) {
            if (isset($this->listCache[$locationId])) {
                return $this->listCache[$locationId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_LIST_SPRINTF, rawurlencode($locationId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        if (!is_array($data[self::KEY_ITEMS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_ITEMS));
        }
        $modes = $this->modesTransformer->transform($data[self::KEY_ITEMS]);
        $this->listCache[$locationId] = $modes;

        return $modes;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByLocationAndId(LocationInterface $location, string $modeId, bool $skipCache = false): ModeInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$modeId])) {
                return $this->cache[$modeId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($location->getLocationId()), rawurlencode($modeId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $mode = $this->modeTransformer->transform($data);
        $this->cache[$modeId] = $mode;

        return $mode;
    }
}
