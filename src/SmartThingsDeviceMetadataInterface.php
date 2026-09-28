<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferencesApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;

interface SmartThingsDeviceMetadataInterface
{
    public function getDeviceHealthApi(): DeviceHealthApiInterface;

    public function getDeviceHistoryApi(): DeviceHistoryApiInterface;

    public function getDevicePreferenceDefinitionApi(): DevicePreferenceDefinitionApiInterface;

    public function getDevicePreferencesApi(): DevicePreferencesApiInterface;

    public function getDeviceProfileApi(): DeviceProfileApiInterface;
}
