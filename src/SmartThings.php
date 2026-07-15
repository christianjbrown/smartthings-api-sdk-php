<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusBatteryTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementHumidityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusRelativeHumidityMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTemperatureTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTemperatureMeasurementTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformer;
use ChristianBrown\SmartThings\Transformer\DevicesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformer;
use ChristianBrown\SmartThings\Transformer\LocationsTransformer;
use ChristianBrown\SmartThings\Transformer\LocationTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SmartThings implements SmartThingsInterface
{
    private string $apiToken;
    private ContainerBuilder $container;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
        $this->container = new ContainerBuilder();
        $this->init();
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
    public function getLocationRoomApi(): LocationRoomApiInterface
    {
        /**
         * @var LocationRoomApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_LOCATION_ROOM_API);

        return $service;
    }

    private function init(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

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

        $this->container->register(self::SERVICE_LOCATION_TRANSFORMER, LocationTransformer::class);
        $this->container->register(self::SERVICE_LOCATIONS_TRANSFORMER, LocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_LOCATION_ROOM_TRANSFORMER, LocationRoomTransformer::class);

        $this->container->register(self::SERVICE_DEVICE_API, DeviceApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICES_TRANSFORMER),
                    $this->apiToken,
                ]
            );
        $this->container->register(self::SERVICE_DEVICE_STATUS_API, DeviceStatusApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_DEVICE_STATUS_TRANSFORMER),
                    $this->apiToken,
                ]
            );
        $this->container->register(self::SERVICE_LOCATION_API, LocationApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LOCATION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_LOCATIONS_TRANSFORMER),
                    $this->apiToken,
                ]
            );
        $this->container->register(self::SERVICE_LOCATION_ROOM_API, LocationRoomApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_LOCATION_ROOM_TRANSFORMER),
                    $this->apiToken,
                ]
            );
    }
}
