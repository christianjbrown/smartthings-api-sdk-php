<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCommandInterface;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceCommandSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformer;
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
     * @var array<string, DeviceInterface>
     */
    private array $deviceCache = [];
    private ?DeviceCommandResultsTransformerInterface $deviceCommandResultsTransformer;
    private ?DeviceCommandSerializerInterface $deviceCommandSerializer;
    private DevicesTransformerInterface $devicesTransformer;
    private DeviceTransformerInterface $deviceTransformer;
    private JsonApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonApiRequestSenderInterface $requestSender, DeviceTransformerInterface $deviceTransformer, DevicesTransformerInterface $devicesTransformer, TokenInterface $token, ?DeviceCommandSerializerInterface $deviceCommandSerializer = null, ?DeviceCommandResultsTransformerInterface $deviceCommandResultsTransformer = null)
    {
        $this->requestSender = $requestSender;
        $this->deviceTransformer = $deviceTransformer;
        $this->devicesTransformer = $devicesTransformer;
        $this->token = $token;
        $this->deviceCommandSerializer = $deviceCommandSerializer;
        $this->deviceCommandResultsTransformer = $deviceCommandResultsTransformer;
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
        $body = [self::KEY_COMMANDS => $this->resolveDeviceCommandSerializer()->serialize($commands)];
        $data = $this->requestSender->post($url, self::buildOrderedQuery($ordered), $headers, $body);

        if (!isset($data[self::KEY_RESULTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RESULTS));
        }
        if (!is_array($data[self::KEY_RESULTS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_RESPONSE_SPRINTF, self::KEY_RESULTS));
        }

        return $this->resolveDeviceCommandResultsTransformer()->transform($data[self::KEY_RESULTS]);
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return array<int, DeviceInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array
    {
        // Cache per location; casting keeps null and a real id as distinct
        // string keys without adding a null-coalescing branch to this method.
        $cacheKey = (string) $locationId;
        if (!$skipCache) {
            if (isset($this->cache[$cacheKey])) {
                return $this->cache[$cacheKey];
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
        $devices = $this->devicesTransformer->transform($data[self::KEY_ITEMS]);
        $this->cache[$cacheKey] = $devices;

        return $devices;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $deviceId, bool $skipCache = false): DeviceInterface
    {
        if (!$skipCache) {
            if (isset($this->deviceCache[$deviceId])) {
                return $this->deviceCache[$deviceId];
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
        $device = $this->deviceTransformer->transform($data);
        $this->deviceCache[$deviceId] = $device;

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

    /**
     * Falls back to the default transformer when the caller (or an older, hand-wired
     * caller) did not supply one, keeping the appended constructor parameter optional.
     */
    private function resolveDeviceCommandResultsTransformer(): DeviceCommandResultsTransformerInterface
    {
        return $this->deviceCommandResultsTransformer ?? new DeviceCommandResultsTransformer(new DeviceCommandResultTransformer());
    }

    /**
     * Falls back to the default serializer when the caller (or an older, hand-wired
     * caller) did not supply one, keeping the appended constructor parameter optional.
     */
    private function resolveDeviceCommandSerializer(): DeviceCommandSerializerInterface
    {
        return $this->deviceCommandSerializer ?? new DeviceCommandSerializer();
    }
}
