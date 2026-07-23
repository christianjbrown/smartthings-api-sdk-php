<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\PresentationInterface;

interface PresentationApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/presentation';
    public const string API_URL_DEVICE_CONFIG = 'https://api.smartthings.com/v1/presentation/deviceconfig';
    public const string API_URL_TYPE_DEVICE_CONFIG_SPRINTF = 'https://api.smartthings.com/v1/presentation/types/%s/deviceconfig';
    public const string CACHE_KEY_SPRINTF = '%s/%s';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_MANUFACTURER_NAME = 'manufacturerName';
    public const string KEY_PRESENTATION_ID = 'presentationId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    public function getByDevice(DeviceInterface $device, bool $skipCache = false): PresentationInterface;

    public function getByDeviceId(string $deviceId, bool $skipCache = false): PresentationInterface;

    public function getDeviceConfig(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface;

    public function getDeviceConfigByType(string $typeIntegrationId, bool $skipCache = false): PresentationInterface;

    public function getOne(string $presentationId, ?string $manufacturerName = null, bool $skipCache = false): PresentationInterface;
}
