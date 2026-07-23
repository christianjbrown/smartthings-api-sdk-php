<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Api;

use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;

interface CapabilityApiInterface extends ApiInterface
{
    public const string API_URL = 'https://api.smartthings.com/v1/capabilities';
    public const string API_URL_NAMESPACE_SPRINTF = 'https://api.smartthings.com/v1/capabilities/namespaces/%s';
    public const string API_URL_NAMESPACES = 'https://api.smartthings.com/v1/capabilities/namespaces';
    public const string API_URL_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s/%s';
    public const string API_URL_VERSIONS_SPRINTF = 'https://api.smartthings.com/v1/capabilities/%s';
    public const string CACHE_KEY_SPRINTF = '%s/%d';
    public const string KEY_ITEMS = 'items';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string UNEXPECTED_RESPONSE_SPRINTF = '%s not set or not an array';

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getMultiple(bool $skipCache = false): array;

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getMultipleByNamespace(string $namespace, bool $skipCache = false): array;

    /**
     * @return array<int, CapabilityNamespaceInterface>
     */
    public function getNamespaces(bool $skipCache = false): array;

    public function getOneByIdAndVersion(string $capabilityId, int $version, bool $skipCache = false): CapabilityInterface;

    /**
     * @return array<int, CapabilityInterface>
     */
    public function getVersions(string $capabilityId, bool $skipCache = false): array;
}
