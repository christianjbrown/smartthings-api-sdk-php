<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\DeviceCommandInterface;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;
use ChristianBrown\SmartThings\Model\DeviceEventInterface;
use ChristianBrown\SmartThings\Model\DeviceInstallRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceRequestInterface;

interface DeviceApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/devices/';
    public const string API_URL_COMMANDS_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/commands';
    public const string API_URL_EVENTS_SPRINTF = 'https://api.smartthings.com/v1/devices/%s/events';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/devices/%s';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_DEVICE_EVENTS = 'deviceEvents';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_ORDERED = 'ordered';
    public const string KEY_RESULTS = 'results';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates one or more attribute-state events for a device. Requires the OAuth token
     * of the SmartApp that created the device.
     *
     * @param string                           $deviceId The device to post events for
     * @param array<int, DeviceEventInterface> $events
     */
    public function createEvents(string $deviceId, array $events): void;

    /**
     * Deletes a device with the given id. Invalidates any cached copy of this device.
     */
    public function deleteDevice(string $deviceId): void;

    /**
     * Executes one or more capability commands on a device. This does not cache: every
     * call re-triggers the device's side effects.
     *
     * @param string                             $deviceId The device to command
     * @param array<int, DeviceCommandInterface> $commands
     * @param null|bool                          $ordered  deprecated by the vendor spec; functionality is not
     *                                                     guaranteed, but still accepted for backward compatibility
     *
     * @return array<int, DeviceCommandResultInterface>
     */
    public function executeCommands(string $deviceId, array $commands, ?bool $ordered = null): array;

    /**
     * @return array<int, DeviceInterface>
     */
    public function getMultiple(?string $locationId = null, bool $skipCache = false): array;

    public function getOneById(string $deviceId, bool $skipCache = false): DeviceInterface;

    /**
     * Installs a SmartApp-managed device. Requires installed app principal.
     */
    public function installDevice(DeviceInstallRequestInterface $request): DeviceInterface;

    /**
     * Updates a device's label, location or room. Refreshes the cached copy of this
     * device.
     */
    public function updateDevice(string $deviceId, UpdateDeviceRequestInterface $request): DeviceInterface;
}
