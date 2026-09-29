<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePresentationInterface;
use ChristianBrown\SmartThings\Model\PresentationInterface;

interface PresentationApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/presentation';
    public const string API_URL_DEVICE_CONFIG = 'https://api.smartthings.com/v1/presentation/deviceconfig';
    public const string API_URL_TYPE_DEVICE_CONFIG_SPRINTF = 'https://api.smartthings.com/v1/presentation/types/%s/deviceconfig';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_EXCLUDE_UNDISPLAYABLE_CAPABILITIES_FROM_PRESENTATION = 'excludeUndisplayableCapabilitiesFromPresentation';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_PRESENTATION_ID = 'presentationId';
    public const string KEY_TYPE_INTEGRATION = 'typeIntegration';
    public const string KEY_TYPE_SHARD_ID = 'typeShardId';
    public const string KEY_VIEW = 'view';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * Creates a device configuration and returns it.
     */
    public function createDeviceConfiguration(DeviceConfigurationRequestInterface $request): DeviceConfigurationInterface;

    /**
     * Generates a device configuration draft for an integration type.
     */
    public function generateDeviceConfiguration(string $typeIntegrationId, ?string $typeIntegration = null, ?string $typeShardId = null, ?bool $excludeUndisplayableCapabilitiesFromPresentation = null, bool $skipCache = false): CreateDeviceConfigRequestInterface;

    public function getByDevice(DeviceInterface $device, bool $skipCache = false): PresentationInterface;

    public function getByDeviceId(string $deviceId, bool $skipCache = false): PresentationInterface;

    public function getDeviceConfig(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface;

    public function getDeviceConfigByType(string $typeIntegrationId, bool $skipCache = false): PresentationInterface;

    /**
     * Reads a device configuration as a typed tree (dashboard, detail view, automation, icons and plugin info).
     */
    public function getDeviceConfiguration(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): DeviceConfigurationInterface;

    /**
     * Reads the presentation of a device as a typed tree. The optional view limits it to the dashboard, detail view or automation.
     */
    public function getDevicePresentation(string $presentationId, ?string $manufacturerName = null, ?string $deviceId = null, ?string $view = null, ?string $ifNoneMatch = null, ?string $acceptLanguage = null, bool $skipCache = false): DevicePresentationInterface;

    public function getOne(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface;
}
