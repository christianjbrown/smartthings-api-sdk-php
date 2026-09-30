<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCommandInterface;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;
use ChristianBrown\SmartThings\Model\DeviceEventInterface;
use ChristianBrown\SmartThings\Model\DeviceInstallRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceListQueryInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceRequestInterface;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceEventSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceInstallRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DeviceApi implements DeviceApiInterface
{
    /**
     * @var array<string, array<int, DeviceInterface>>
     */
    private array $cache = [];

    /**
     * @var array<string, array<string, DeviceInterface>>
     */
    private array $deviceCache = [];
    private DeviceCommandResultsTransformerInterface $deviceCommandResultsTransformer;
    private DeviceCommandSerializerInterface $deviceCommandSerializer;
    private DeviceEventSerializerInterface $deviceEventSerializer;
    private DeviceInstallRequestSerializerInterface $deviceInstallRequestSerializer;
    private DevicesTransformerInterface $devicesTransformer;
    private DeviceTransformerInterface $deviceTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;
    private UpdateDeviceRequestSerializerInterface $updateDeviceRequestSerializer;
    private RequestUrlBuilderInterface $urlBuilder;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceTransformerInterface $deviceTransformer, DevicesTransformerInterface $devicesTransformer, TokenInterface $token, DeviceCommandSerializerInterface $deviceCommandSerializer, DeviceCommandResultsTransformerInterface $deviceCommandResultsTransformer, DeviceInstallRequestSerializerInterface $deviceInstallRequestSerializer, UpdateDeviceRequestSerializerInterface $updateDeviceRequestSerializer, DeviceEventSerializerInterface $deviceEventSerializer, RequestUrlBuilderInterface $urlBuilder)
    {
        $this->requestSender = $requestSender;
        $this->deviceTransformer = $deviceTransformer;
        $this->devicesTransformer = $devicesTransformer;
        $this->token = $token;
        $this->deviceCommandSerializer = $deviceCommandSerializer;
        $this->deviceCommandResultsTransformer = $deviceCommandResultsTransformer;
        $this->deviceInstallRequestSerializer = $deviceInstallRequestSerializer;
        $this->updateDeviceRequestSerializer = $updateDeviceRequestSerializer;
        $this->deviceEventSerializer = $deviceEventSerializer;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param string                           $deviceId The device to post events for
     * @param array<int, DeviceEventInterface> $events
     *
     * @throws RequestExceptionInterface
     */
    public function createEvents(string $deviceId, array $events): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_EVENTS_SPRINTF, rawurlencode($deviceId));
        $body = [self::KEY_DEVICE_EVENTS => $this->deviceEventSerializer->serialize($events)];
        $this->requestSender->post($url, [], $headers, $body);
    }

    /**
     * @throws RequestExceptionInterface
     */
    public function deleteDevice(string $deviceId): void
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceId));
        $this->requestSender->delete($url, [], $headers);
        unset($this->deviceCache[$deviceId]);
    }

    /**
     * @param string                             $deviceId The device to command
     * @param array<int, DeviceCommandInterface> $commands
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceCommandResultInterface>
     */
    public function executeCommands(string $deviceId, array $commands, ?bool $ordered = null): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_COMMANDS_SPRINTF, rawurlencode($deviceId));
        $body = [self::KEY_COMMANDS => $this->deviceCommandSerializer->serialize($commands)];
        $data = $this->requestSender->post($url, self::buildOrderedQuery($ordered), $headers, $body);

        if (!isset($data[self::KEY_RESULTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RESULTS));
        }
        if (!is_array($data[self::KEY_RESULTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RESULTS));
        }

        return $this->deviceCommandResultsTransformer->transform($data[self::KEY_RESULTS]);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false, ?DeviceListQueryInterface $query = null): array
    {
        // The full URL, query included, identifies the request, so it keys the cache.
        $url = $this->urlBuilder->build(self::API_URL, [self::KEY_LOCATION_ID => $locationId], $query);
        if (!$skipCache) {
            if (isset($this->cache[$url])) {
                return $this->cache[$url];
            }
        }

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
        $devices = $this->devicesTransformer->transform($data[self::KEY_ITEMS]);
        $this->cache[$url] = $devices;

        return $devices;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceId, bool $skipCache = false, ?bool $includeStatus = null): DeviceInterface
    {
        $url = $this->urlBuilder->build(sprintf(self::API_URL_SPRINTF, rawurlencode($deviceId)), [self::KEY_INCLUDE_STATUS => $includeStatus]);
        if (!$skipCache) {
            if (isset($this->deviceCache[$deviceId][$url])) {
                return $this->deviceCache[$deviceId][$url];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $device = $this->deviceTransformer->transform($data);
        $this->deviceCache[$deviceId][$url] = $device;

        return $device;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function installDevice(DeviceInstallRequestInterface $request): DeviceInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $body = $this->deviceInstallRequestSerializer->serialize($request);
        $data = $this->requestSender->post(self::API_URL, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $device = $this->deviceTransformer->transform($data);
        $this->deviceCache[$device->getDeviceId()] = [sprintf(self::API_URL_SPRINTF, rawurlencode($device->getDeviceId())) => $device];

        return $device;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function updateDevice(string $deviceId, UpdateDeviceRequestInterface $request): DeviceInterface
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_SPRINTF, rawurlencode($deviceId));
        $body = $this->updateDeviceRequestSerializer->serialize($request);
        $data = $this->requestSender->put($url, [], $headers, $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $device = $this->deviceTransformer->transform($data);
        $this->deviceCache[$deviceId] = [$url => $device];

        return $device;
    }

    /**
     * @return array<string, string>
     */
    private static function buildOrderedQuery(?bool $ordered): array
    {
        // Isolated so the optional filter is its own path, not multiplied
        // against the response-shape guards in executeCommands().
        if (null === $ordered) {
            return [];
        }

        return [self::KEY_ORDERED => $ordered ? 'true' : 'false'];
    }
}
