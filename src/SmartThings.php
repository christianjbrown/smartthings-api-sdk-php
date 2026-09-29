<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\ChannelApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferencesApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\DriverApiInterface;
use ChristianBrown\SmartThings\Api\HubApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Api\OrganizationApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\SchemaAppInviteApiInterface;
use ChristianBrown\SmartThings\Api\SchemaConnectorApiInterface;
use ChristianBrown\SmartThings\Api\ServiceApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;
use ChristianBrown\SmartThings\Api\TextToSpeechApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApiInterface;
use ChristianBrown\SmartThings\DependencyInjection\ContainerFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SmartThings implements SmartThingsInterface
{
    private ContainerBuilder $container;
    private TokenInterface $token;

    public function __construct(string $apiToken, ?ApiHostInterface $apiHost = null)
    {
        $this->token = new Token($apiToken);
        $this->container = (new ContainerFactory($this->token, $apiHost ?? new ApiHost()))->build();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAppApi(): AppApiInterface
    {
        /**
         * @var AppApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_APP_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCapabilityApi(): CapabilityApiInterface
    {
        /**
         * @var CapabilityApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_CAPABILITY_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getChannelApi(): ChannelApiInterface
    {
        /**
         * @var ChannelApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_CHANNEL_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeviceApi(): DeviceApiInterface
    {
        /**
         * @var DeviceApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeviceHealthApi(): DeviceHealthApiInterface
    {
        /**
         * @var DeviceHealthApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_HEALTH_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeviceHistoryApi(): DeviceHistoryApiInterface
    {
        /**
         * @var DeviceHistoryApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_HISTORY_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDevicePreferenceDefinitionApi(): DevicePreferenceDefinitionApiInterface
    {
        /**
         * @var DevicePreferenceDefinitionApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_PREFERENCE_DEFINITION_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDevicePreferencesApi(): DevicePreferencesApiInterface
    {
        /**
         * @var DevicePreferencesApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_PREFERENCES_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeviceProfileApi(): DeviceProfileApiInterface
    {
        /**
         * @var DeviceProfileApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_PROFILE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeviceStatusApi(): DeviceStatusApiInterface
    {
        /**
         * @var DeviceStatusApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DEVICE_STATUS_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDriverApi(): DriverApiInterface
    {
        /**
         * @var DriverApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_DRIVER_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getHubApi(): HubApiInterface
    {
        /**
         * @var HubApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_HUB_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getInstalledAppApi(): InstalledAppApiInterface
    {
        /**
         * @var InstalledAppApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_INSTALLED_APP_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLocationApi(): LocationApiInterface
    {
        /**
         * @var LocationApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATION_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLocationModeApi(): LocationModeApiInterface
    {
        /**
         * @var LocationModeApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATION_MODE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLocationRoomApi(): LocationRoomApiInterface
    {
        /**
         * @var LocationRoomApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATION_ROOM_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOrganizationApi(): OrganizationApiInterface
    {
        /**
         * @var OrganizationApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ORGANIZATION_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPresentationApi(): PresentationApiInterface
    {
        /**
         * @var PresentationApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_PRESENTATION_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getRuleApi(): RuleApiInterface
    {
        /**
         * @var RuleApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_RULE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSceneApi(): SceneApiInterface
    {
        /**
         * @var SceneApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SCENE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getScheduleApi(): ScheduleApiInterface
    {
        /**
         * @var ScheduleApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SCHEDULE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSchemaAppInviteApi(): SchemaAppInviteApiInterface
    {
        /**
         * @var SchemaAppInviteApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SCHEMA_APP_INVITE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSchemaConnectorApi(): SchemaConnectorApiInterface
    {
        /**
         * @var SchemaConnectorApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SCHEMA_CONNECTOR_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getServiceApi(): ServiceApiInterface
    {
        /**
         * @var ServiceApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SERVICE_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSubscriptionApi(): SubscriptionApiInterface
    {
        /**
         * @var SubscriptionApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SUBSCRIPTION_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTextToSpeechApi(): TextToSpeechApiInterface
    {
        /**
         * @var TextToSpeechApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_TEXT_TO_SPEECH_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getVirtualDeviceApi(): VirtualDeviceApiInterface
    {
        /**
         * @var VirtualDeviceApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_VIRTUAL_DEVICE_API);

        return $service;
    }
}
