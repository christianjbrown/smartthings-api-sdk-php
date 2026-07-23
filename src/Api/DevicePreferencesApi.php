<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformerInterface;

use function rawurlencode;
use function sprintf;

final class DevicePreferencesApi implements DevicePreferencesApiInterface
{
    /**
     * @var array<string, array<int, DevicePreferenceInterface>>
     */
    private array $cache = [];
    private DevicePreferencesTransformerInterface $devicePreferencesTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DevicePreferencesTransformerInterface $devicePreferencesTransformer, TokenInterface $token)
    {
        $this->requestSender = $requestSender;
        $this->devicePreferencesTransformer = $devicePreferencesTransformer;
        $this->token = $token;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DevicePreferenceInterface>
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): array
    {
        return $this->getOneById($device->getDeviceId(), $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DevicePreferenceInterface>
     */
    public function getOneById(string $deviceId, bool $skipCache = false): array
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
        $preferences = $this->devicePreferencesTransformer->transform($data);
        $this->cache[$deviceId] = $preferences;

        return $preferences;
    }
}
