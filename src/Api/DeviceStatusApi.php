<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DeviceStatusApi implements DeviceStatusApiInterface
{
    private TokenInterface $token;

    /**
     * @var array<string, DeviceStatusInterface>
     */
    private array $cache = [];
    private DeviceStatusTransformerInterface $deviceStatusTransformer;
    private JsonApiRequestSenderInterface $requestSender;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceStatusTransformerInterface $deviceStatusTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->deviceStatusTransformer = $deviceStatusTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): DeviceStatusInterface
    {
        return $this->getOneById($device->getDeviceId(), $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceId, bool $skipCache = false): DeviceStatusInterface
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

        if (empty($data[self::KEY_COMPONENTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COMPONENTS));
        }
        if (!is_array($data[self::KEY_COMPONENTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COMPONENTS));
        }
        $components = $data[self::KEY_COMPONENTS];
        if (empty($components[self::KEY_COMPONENTS_MAIN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COMPONENTS_MAIN));
        }
        if (!is_array($components[self::KEY_COMPONENTS_MAIN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_COMPONENTS_MAIN));
        }
        $status = $this->deviceStatusTransformer->transform($components[self::KEY_COMPONENTS_MAIN]);
        $this->cache[$deviceId] = $status;

        return $status;
    }
}
