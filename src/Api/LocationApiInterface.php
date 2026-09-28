<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CreateLocationRequestInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\PatchLocationRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateLocationRequestInterface;

interface LocationApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/locations';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s';
    public const string KEY_FORCE = 'force';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Creates a new Location. Invalidates the cached location list so a subsequent
     * getMultiple() reflects the new Location.
     */
    public function createLocation(CreateLocationRequestInterface $request): LocationInterface;

    /**
     * Deletes a Location from the user's account. Invalidates any cached copy of this
     * location and the cached location list.
     */
    public function deleteLocation(string $locationId, ?bool $force = null): void;

    /**
     * @return array<int, LocationInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    public function getOneById(string $locationId, bool $skipCache = false): LocationInterface;

    /**
     * Updates or unsets one or more of a Location's latitude, longitude and
     * regionRadius fields, without touching the others. Refreshes the cached copy of
     * this location and invalidates the cached location list.
     */
    public function patchLocation(string $locationId, PatchLocationRequestInterface $request): LocationInterface;

    /**
     * Updates one or more fields of a Location; all fields but name are optional.
     * Refreshes the cached copy of this location and invalidates the cached location
     * list.
     */
    public function updateLocation(string $locationId, UpdateLocationRequestInterface $request): LocationInterface;
}
