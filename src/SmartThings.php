<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApi;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApi;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApi;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\RuleApiInterface;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApi;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\SubscriptionApi;
use ChristianBrown\SmartThings\Api\SubscriptionApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppsTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use ChristianBrown\SmartThings\Transformer\ModesTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationTransformer;
use ChristianBrown\SmartThings\Transformer\RulesTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SmartThings implements SmartThingsInterface
{
    private ContainerBuilder $container;
    private TokenInterface $token;

    public function __construct(string $apiToken)
    {
        $this->container = new ContainerBuilder();
        $this->token = new Token($apiToken);
        $this->init();
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
    public function getSubscriptionApi(): SubscriptionApiInterface
    {
        /**
         * @var SubscriptionApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_SUBSCRIPTION_API);

        return $service;
    }

    private function init(): void
    {
        // Registration order matters: a service must be registered before another
        // service wires a reference to its definition, so core comes first and the
        // API clients (which reference every transformer chain) come last.
        $this->registerCore();
        $this->registerAppTransformers();
        $this->registerCapabilityTransformers();
        $this->registerDeviceTransformers();
        $this->registerDeviceHealthTransformers();
        $this->registerDeviceHistoryTransformers();
        $this->registerDeviceProfileTransformers();
        $this->registerDeviceStatusTransformers();
        $this->registerInstalledAppTransformers();
        $this->registerLocationTransformers();
        $this->registerModeTransformers();
        $this->registerPresentationTransformers();
        $this->registerRuleTransformers();
        $this->registerSceneTransformers();
        $this->registerScheduleTransformers();
        $this->registerSubscriptionTransformers();
        $this->registerApiClients();
    }

    private function registerApiClients(): void
    {
        $this->container->register(self::SERVICE_APP_API, AppApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_APP_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_APPS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_APP_OAUTH_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_APP_SETTINGS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_CAPABILITY_API, CapabilityApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_CAPABILITY_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CAPABILITIES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_API, DeviceApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DEVICES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_HEALTH_API, DeviceHealthApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_HEALTH_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_HISTORY_API, DeviceHistoryApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_PROFILE_API, DeviceProfileApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_PROFILE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_PROFILES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_STATUS_API, DeviceStatusApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_INSTALLED_APP_API, InstalledAppApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APP_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APPS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_LOCATION_API, LocationApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LOCATIONS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_LOCATION_MODE_API, LocationModeApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_MODE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_MODES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_LOCATION_ROOM_API, LocationRoomApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LOCATION_ROOM_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LOCATION_ROOMS_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_PRESENTATION_API, PresentationApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_PRESENTATION_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_RULE_API, RuleApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_RULE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_RULES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_SCENE_API, SceneApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_SCENE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SCENES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_SCHEDULE_API, ScheduleApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_SCHEDULE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SCHEDULES_TRANSFORMER),
                    $this->token,
                ]
            );
        $this->container->register(self::SERVICE_SUBSCRIPTION_API, SubscriptionApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_SUBSCRIPTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SUBSCRIPTIONS_TRANSFORMER),
                    $this->token,
                ]
            );
    }

    private function registerAppTransformers(): void
    {
        $this->container->register(self::SERVICE_APP_TRANSFORMER, AppTransformer::class);
        $this->container->register(self::SERVICE_APPS_TRANSFORMER, AppsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_APP_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_APP_OAUTH_TRANSFORMER, AppOauthTransformer::class);
        $this->container->register(self::SERVICE_APP_SETTINGS_TRANSFORMER, AppSettingsTransformer::class);
    }

    private function registerCapabilityTransformers(): void
    {
        $this->container->register(self::SERVICE_CAPABILITY_TRANSFORMER, CapabilityTransformer::class);
        $this->container->register(self::SERVICE_CAPABILITIES_TRANSFORMER, CapabilitiesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CAPABILITY_TRANSFORMER),
                ]
            );
    }

    private function registerCore(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);
    }

    private function registerDeviceHealthTransformers(): void
    {
        $this->container->register(self::SERVICE_DEVICE_HEALTH_TRANSFORMER, DeviceHealthTransformer::class);
    }

    private function registerDeviceHistoryTransformers(): void
    {
        $this->container->register(self::SERVICE_DEVICE_HISTORY_EVENT_TRANSFORMER, DeviceHistoryEventTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_HISTORY_EVENTS_TRANSFORMER, DeviceHistoryEventsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_HISTORY_EVENT_TRANSFORMER),
                ]
            );
    }

    private function registerDeviceProfileTransformers(): void
    {
        $this->container->register(self::SERVICE_DEVICE_PROFILE_TRANSFORMER, DeviceProfileTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_PROFILES_TRANSFORMER, DeviceProfilesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_PROFILE_TRANSFORMER),
                ]
            );
    }

    private function registerDeviceStatusTransformers(): void
    {
        $this->container->register(self::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER, DeviceStatusTemperatureMeasurementTemperatureTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER, DeviceStatusTemperatureMeasurementTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TEMPERATURE_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER, DeviceStatusRelativeHumidityMeasurementHumidityTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER, DeviceStatusRelativeHumidityMeasurementTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_HUMIDITY_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER, DeviceStatusBatteryBatteryTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER, DeviceStatusBatteryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_BATTERY_BATTERY_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_STATUS_TRANSFORMER, DeviceStatusTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_TEMPERATURE_MEASUREMENT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_RELATIVE_HUMIDITY_MEASUREMENT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_BATTERY_TRANSFORMER),
                ]
            );
    }

    private function registerDeviceTransformers(): void
    {
        $this->container->register(self::SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER, DeviceComponentCapabilityTransformer::class);
        $this->container->register(self::SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER, DeviceComponentCapabilitiesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_COMPONENT_CAPABILITY_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_COMPONENT_TRANSFORMER, DeviceComponentTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_COMPONENT_CAPABILITIES_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_COMPONENTS_TRANSFORMER, DeviceComponentsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_COMPONENT_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_TRANSFORMER, DeviceTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_COMPONENTS_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_DEVICES_TRANSFORMER, DevicesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_DEVICE_TRANSFORMER),
                ]
            );
    }

    private function registerInstalledAppTransformers(): void
    {
        $this->container->register(self::SERVICE_INSTALLED_APP_TRANSFORMER, InstalledAppTransformer::class);
        $this->container->register(self::SERVICE_INSTALLED_APPS_TRANSFORMER, InstalledAppsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APP_TRANSFORMER),
                ]
            );
        $this->container->register(self::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER, InstalledAppConfigTransformer::class);
        $this->container->register(self::SERVICE_INSTALLED_APP_CONFIGS_TRANSFORMER, InstalledAppConfigsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_INSTALLED_APP_CONFIG_TRANSFORMER),
                ]
            );
    }

    private function registerLocationTransformers(): void
    {
        $this->container->register(self::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $this->container->register(self::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LOCATION_ROOM_TRANSFORMER, LocationRoomTransformer::class);
        $this->container->register(self::SERVICE_LOCATION_ROOMS_TRANSFORMER, LocationRoomsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LOCATION_ROOM_TRANSFORMER),
                ]
            );
    }

    private function registerModeTransformers(): void
    {
        $this->container->register(self::SERVICE_MODE_TRANSFORMER, ModeTransformer::class);
        $this->container->register(self::SERVICE_MODES_TRANSFORMER, ModesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_MODE_TRANSFORMER),
                ]
            );
    }

    private function registerPresentationTransformers(): void
    {
        $this->container->register(self::SERVICE_PRESENTATION_TRANSFORMER, PresentationTransformer::class);
    }

    private function registerRuleTransformers(): void
    {
        $this->container->register(self::SERVICE_RULE_TRANSFORMER, RuleTransformer::class);
        $this->container->register(self::SERVICE_RULES_TRANSFORMER, RulesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_RULE_TRANSFORMER),
                ]
            );
    }

    private function registerSceneTransformers(): void
    {
        $this->container->register(self::SERVICE_SCENE_TRANSFORMER, SceneTransformer::class);
        $this->container->register(self::SERVICE_SCENES_TRANSFORMER, ScenesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SCENE_TRANSFORMER),
                ]
            );
    }

    private function registerScheduleTransformers(): void
    {
        $this->container->register(self::SERVICE_SCHEDULE_TRANSFORMER, ScheduleTransformer::class);
        $this->container->register(self::SERVICE_SCHEDULES_TRANSFORMER, SchedulesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SCHEDULE_TRANSFORMER),
                ]
            );
    }

    private function registerSubscriptionTransformers(): void
    {
        $this->container->register(self::SERVICE_SUBSCRIPTION_TRANSFORMER, SubscriptionTransformer::class);
        $this->container->register(self::SERVICE_SUBSCRIPTIONS_TRANSFORMER, SubscriptionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SUBSCRIPTION_TRANSFORMER),
                ]
            );
    }
}
