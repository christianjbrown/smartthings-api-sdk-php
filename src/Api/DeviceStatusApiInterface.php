<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;
use ChristianBrown\SmartThings\Model\ComponentStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusReportInterface;

interface DeviceStatusApiInterface extends ApiInterface
{
    public const string API_URL_CAPABILITY_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/components/%s/capabilities/%s/status';
    public const string API_URL_COMPONENT_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/components/%s/status';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/status';
    public const string CACHE_KEY_CAPABILITY_SPRINTF = '%s/%s/%s';
    public const string CACHE_KEY_COMPONENT_SPRINTF = '%s/%s';
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_COMPONENTS_MAIN = 'main';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Every attribute of one capability of a component, keyed by attribute name.
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getCapabilityReport(string $deviceId, string $componentId, string $capabilityId, bool $skipCache = false): CapabilityStatusInterface;

    /**
     * Every capability and attribute of one component.
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getComponentReport(string $deviceId, string $componentId, bool $skipCache = false): ComponentStatusInterface;

    public function getOneByCapability(string $deviceId, string $componentId, string $capabilityId, bool $skipCache = false): DeviceStatusInterface;

    public function getOneByComponent(string $deviceId, string $componentId, bool $skipCache = false): DeviceStatusInterface;

    public function getOneByDevice(DeviceInterface $device, bool $skipCache = false): DeviceStatusInterface;

    public function getOneById(string $deviceId, bool $skipCache = false): DeviceStatusInterface;

    /**
     * Every component, capability and attribute of a device, and its health state.
     *
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getReportById(string $deviceId, bool $skipCache = false): DeviceStatusReportInterface;
}
