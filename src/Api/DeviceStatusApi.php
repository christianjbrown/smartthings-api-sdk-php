<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonReadApiRequestSenderInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;
use ChristianBrown\SmartThings\Model\ComponentStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusReportInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ComponentStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusReportTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformerInterface;

use function is_array;
use function rawurlencode;
use function sprintf;

final class DeviceStatusApi implements DeviceStatusApiInterface
{
    /**
     * @var array<string, DeviceStatusInterface>
     */
    private array $cache = [];

    /**
     * @var array<string, DeviceStatusInterface>
     */
    private array $capabilityCache = [];

    /**
     * @var array<string, CapabilityStatusInterface>
     */
    private array $capabilityReportCache = [];
    private CapabilityStatusTransformerInterface $capabilityStatusTransformer;

    /**
     * @var array<string, DeviceStatusInterface>
     */
    private array $componentCache = [];

    /**
     * @var array<string, ComponentStatusInterface>
     */
    private array $componentReportCache = [];
    private ComponentStatusTransformerInterface $componentStatusTransformer;
    private DeviceStatusReportTransformerInterface $deviceStatusReportTransformer;
    private DeviceStatusTransformerInterface $deviceStatusTransformer;

    /**
     * @var array<string, DeviceStatusReportInterface>
     */
    private array $reportCache = [];
    private JsonReadApiRequestSenderInterface $requestSender;
    private TokenInterface $token;

    public function __construct(JsonReadApiRequestSenderInterface $requestSender, DeviceStatusTransformerInterface $deviceStatusTransformer, TokenInterface $token, DeviceStatusReportTransformerInterface $deviceStatusReportTransformer, ComponentStatusTransformerInterface $componentStatusTransformer, CapabilityStatusTransformerInterface $capabilityStatusTransformer)
    {
        $this->requestSender = $requestSender;
        $this->deviceStatusTransformer = $deviceStatusTransformer;
        $this->token = $token;
        $this->deviceStatusReportTransformer = $deviceStatusReportTransformer;
        $this->componentStatusTransformer = $componentStatusTransformer;
        $this->capabilityStatusTransformer = $capabilityStatusTransformer;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCapabilityReport(string $deviceId, string $componentId, string $capabilityId, bool $skipCache = false): CapabilityStatusInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_CAPABILITY_SPRINTF, $deviceId, $componentId, $capabilityId);
        if (!$skipCache) {
            if (isset($this->capabilityReportCache[$cacheKey])) {
                return $this->capabilityReportCache[$cacheKey];
            }
        }

        $data = $this->fetch(sprintf(self::API_URL_CAPABILITY_SPRINTF, rawurlencode($deviceId), rawurlencode($componentId), rawurlencode($capabilityId)));
        $report = $this->capabilityStatusTransformer->transform($data);
        $this->capabilityReportCache[$cacheKey] = $report;

        return $report;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getComponentReport(string $deviceId, string $componentId, bool $skipCache = false): ComponentStatusInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_COMPONENT_SPRINTF, $deviceId, $componentId);
        if (!$skipCache) {
            if (isset($this->componentReportCache[$cacheKey])) {
                return $this->componentReportCache[$cacheKey];
            }
        }

        $data = $this->fetch(sprintf(self::API_URL_COMPONENT_SPRINTF, rawurlencode($deviceId), rawurlencode($componentId)));
        $report = $this->componentStatusTransformer->transform($data);
        $this->componentReportCache[$cacheKey] = $report;

        return $report;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByCapability(string $deviceId, string $componentId, string $capabilityId, bool $skipCache = false): DeviceStatusInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_CAPABILITY_SPRINTF, $deviceId, $componentId, $capabilityId);
        if (!$skipCache) {
            if (isset($this->capabilityCache[$cacheKey])) {
                return $this->capabilityCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_CAPABILITY_SPRINTF, rawurlencode($deviceId), rawurlencode($componentId), rawurlencode($capabilityId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        // The capability-status endpoint returns just that capability's attributes,
        // so re-wrap it under the capability id to feed the shared status transformer.
        $status = $this->deviceStatusTransformer->transform([$capabilityId => $data]);
        $this->capabilityCache[$cacheKey] = $status;

        return $status;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByComponent(string $deviceId, string $componentId, bool $skipCache = false): DeviceStatusInterface
    {
        $cacheKey = sprintf(self::CACHE_KEY_COMPONENT_SPRINTF, $deviceId, $componentId);
        if (!$skipCache) {
            if (isset($this->componentCache[$cacheKey])) {
                return $this->componentCache[$cacheKey];
            }
        }

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $url = sprintf(self::API_URL_COMPONENT_SPRINTF, rawurlencode($deviceId), rawurlencode($componentId));
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        // The component-status endpoint returns the component's capability map
        // directly, the same shape as the `main` block, so feed it straight in.
        $status = $this->deviceStatusTransformer->transform($data);
        $this->componentCache[$cacheKey] = $status;

        return $status;
    }

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): DeviceStatusInterface
    {
        return $this->getOneById($device->getDeviceId(), $skipCache);
    }

    /**
     * @phpstan-impure
     *
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

    /**
     * @phpstan-impure
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getReportById(string $deviceId, bool $skipCache = false): DeviceStatusReportInterface
    {
        if (!$skipCache) {
            if (isset($this->reportCache[$deviceId])) {
                return $this->reportCache[$deviceId];
            }
        }

        $data = $this->fetch(sprintf(self::API_URL_SPRINTF, rawurlencode($deviceId)));
        $report = $this->deviceStatusReportTransformer->transform($data);
        $this->reportCache[$deviceId] = $report;

        return $report;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     *
     * @return mixed[]
     */
    private function fetch(string $url): array
    {
        $headers = [
            self::HEADER_KEY_AUTHORIZATION => $this->token->toAuthorizationHeaderValue(),
        ];
        $data = $this->requestSender->get($url, [], $headers);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $data;
    }
}
