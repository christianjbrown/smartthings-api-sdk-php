<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;

interface DevicePreferenceDefinitionApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/devicepreferences';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devicepreferences/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_NAMESPACE = 'namespace';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function getMultiple(?string $namespace = null, bool $skipCache = false): array;

    public function getOneById(string $preferenceId, bool $skipCache = false): DevicePreferenceDefinitionInterface;
}
