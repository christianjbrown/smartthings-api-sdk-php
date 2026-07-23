<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests;

use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceHealthApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\RuleApi;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\SmartThings;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformer;
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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SmartThings::class)]
#[UsesClass(CapabilityApi::class)]
#[UsesClass(DeviceApi::class)]
#[UsesClass(DeviceHealthApi::class)]
#[UsesClass(DeviceProfileApi::class)]
#[UsesClass(DeviceStatusApi::class)]
#[UsesClass(LocationApi::class)]
#[UsesClass(LocationModeApi::class)]
#[UsesClass(LocationRoomApi::class)]
#[UsesClass(PresentationApi::class)]
#[UsesClass(RuleApi::class)]
#[UsesClass(SceneApi::class)]
#[UsesClass(Token::class)]
#[UsesClass(CapabilitiesTransformer::class)]
#[UsesClass(CapabilityTransformer::class)]
#[UsesClass(DeviceComponentCapabilitiesTransformer::class)]
#[UsesClass(DeviceComponentCapabilityTransformer::class)]
#[UsesClass(DeviceComponentsTransformer::class)]
#[UsesClass(DeviceComponentTransformer::class)]
#[UsesClass(DeviceHealthTransformer::class)]
#[UsesClass(DeviceProfilesTransformer::class)]
#[UsesClass(DeviceProfileTransformer::class)]
#[UsesClass(DevicesTransformer::class)]
#[UsesClass(DeviceStatusBatteryBatteryTransformer::class)]
#[UsesClass(DeviceStatusBatteryTransformer::class)]
#[UsesClass(DeviceStatusRelativeHumidityMeasurementHumidityTransformer::class)]
#[UsesClass(DeviceStatusRelativeHumidityMeasurementTransformer::class)]
#[UsesClass(DeviceStatusTemperatureMeasurementTemperatureTransformer::class)]
#[UsesClass(DeviceStatusTemperatureMeasurementTransformer::class)]
#[UsesClass(DeviceStatusTransformer::class)]
#[UsesClass(DeviceTransformer::class)]
#[UsesClass(LocationsTransformer::class)]
#[UsesClass(LocationTransformer::class)]
#[UsesClass(LocationRoomsTransformer::class)]
#[UsesClass(LocationRoomTransformer::class)]
#[UsesClass(ModesTransformer::class)]
#[UsesClass(ModeTransformer::class)]
#[UsesClass(PresentationTransformer::class)]
#[UsesClass(RulesTransformer::class)]
#[UsesClass(RuleTransformer::class)]
#[UsesClass(ScenesTransformer::class)]
#[UsesClass(SceneTransformer::class)]
final class SmartThingsTest extends TestCase
{
    public function testGetCapabilityApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(CapabilityApi::class, $smartThings->getCapabilityApi());
    }

    public function testGetDeviceApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceApi::class, $smartThings->getDeviceApi());
    }

    public function testGetDeviceHealthApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceHealthApi::class, $smartThings->getDeviceHealthApi());
    }

    public function testGetDeviceProfileApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceProfileApi::class, $smartThings->getDeviceProfileApi());
    }

    public function testGetDeviceStatusApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(DeviceStatusApi::class, $smartThings->getDeviceStatusApi());
    }

    public function testGetLocationApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationApi::class, $smartThings->getLocationApi());
    }

    public function testGetLocationModeApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationModeApi::class, $smartThings->getLocationModeApi());
    }

    public function testGetLocationRoomApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(LocationRoomApi::class, $smartThings->getLocationRoomApi());
    }

    public function testGetPresentationApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(PresentationApi::class, $smartThings->getPresentationApi());
    }

    public function testGetRuleApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(RuleApi::class, $smartThings->getRuleApi());
    }

    public function testGetSceneApi(): void
    {
        $smartThings = new SmartThings('token');

        self::assertInstanceOf(SceneApi::class, $smartThings->getSceneApi());
    }
}
