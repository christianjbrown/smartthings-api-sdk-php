<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHealthInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformerInterface;

use function rawurlencode;
use function sprintf;

final class DeviceHealthApi implements DeviceHealthApiInterface
{
    /**
     * @var array<string, DeviceHealthInterface>
     */
    private array $cache = [];
    private DeviceHealthTransformerInterface $deviceHealthTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceHealthTransformerInterface $deviceHealthTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->deviceHealthTransformer = $deviceHealthTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): DeviceHealthInterface
    {
        return $this->getOneById($device->getDeviceId(), $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceId, bool $skipCache = false): DeviceHealthInterface
    {
        if (!$skipCache) {
            if (isset($this->cache[$deviceId])) {
                return $this->cache[$deviceId];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $health = $this->deviceHealthTransformer->transform($data);
        $this->cache[$deviceId] = $health;

        return $health;
    }
}
