<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;

interface LocationModeApiInterface extends ApiInterface
{
    public const string API_URL_CURRENT_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes/current';
    public const string API_URL_LIST_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/locations/%s/modes/%s';
    public const string KEY_ITEMS = 'items';
    public const string KEY_LABEL = 'label';
    public const string KEY_MODE_ID = 'modeId';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * Switches the Location's currently active Mode. This can trigger any automations
     * for which the new Mode is a trigger, and does not cache: every call re-triggers
     * those side effects and refreshes the cached "current mode" for this location.
     */
    public function changeCurrent(LocationInterface $location, string $modeId): ModeInterface;

    /**
     * Creates a new Mode for the Location. Invalidates the cached mode list for this
     * location so a subsequent getMultiple() reflects the new Mode.
     */
    public function createMode(LocationInterface $location, string $label): ModeInterface;

    /**
     * Deletes a Mode from the Location. Invalidates any cached copy of this Mode and
     * the cached mode list for this location.
     */
    public function deleteMode(LocationInterface $location, string $modeId): void;

    public function getCurrent(LocationInterface $location, bool $skipCache = false): ModeInterface;

    /**
     * @return array<int, ModeInterface>
     */
    public function getMultiple(LocationInterface $location, bool $skipCache = false): array;

    public function getOneByLocationAndId(LocationInterface $location, string $modeId, bool $skipCache = false): ModeInterface;

    /**
     * Updates a Mode's label. Refreshes the cached copy of this Mode and invalidates
     * the cached mode list for this location.
     */
    public function updateMode(LocationInterface $location, string $modeId, string $label): ModeInterface;
}
