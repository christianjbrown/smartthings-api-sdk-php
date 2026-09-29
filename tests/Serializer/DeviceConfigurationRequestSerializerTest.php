<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequest;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomationInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDetailViewSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestAutomationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationRequest::class)]
#[CoversClass(DeviceConfigurationRequestSerializer::class)]
final class DeviceConfigurationRequestSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemSerializer = self::createStub(DeviceConfigurationIconsItemSerializerInterface::class);
        $deviceConfigurationIconsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item']);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardSerializer = self::createStub(DeviceConfigurationDashboardSerializerInterface::class);
        $deviceConfigurationDashboardSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dashboard']);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewSerializer = self::createStub(DeviceConfigEntryForDetailViewSerializerInterface::class);
        $deviceConfigEntryForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-detail-view']);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationSerializer = self::createStub(DeviceConfigurationRequestAutomationSerializerInterface::class);
        $deviceConfigurationRequestAutomationSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-request-automation']);
        $model = new DeviceConfigurationRequest();

        $serializer = new DeviceConfigurationRequestSerializer($deviceConfigurationIconsItemSerializer, $deviceConfigurationDashboardSerializer, $deviceConfigEntryForDetailViewSerializer, $deviceConfigurationRequestAutomationSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemSerializer = self::createStub(DeviceConfigurationIconsItemSerializerInterface::class);
        $deviceConfigurationIconsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item']);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardSerializer = self::createStub(DeviceConfigurationDashboardSerializerInterface::class);
        $deviceConfigurationDashboardSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dashboard']);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewSerializer = self::createStub(DeviceConfigEntryForDetailViewSerializerInterface::class);
        $deviceConfigEntryForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-detail-view']);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationSerializer = self::createStub(DeviceConfigurationRequestAutomationSerializerInterface::class);
        $deviceConfigurationRequestAutomationSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-request-automation']);
        $model = (new DeviceConfigurationRequest())
            ->setIconUrl('test-icon-url')
            ->setIcons([$deviceConfigurationIconsItemModel])
            ->setDashboard($deviceConfigurationDashboardModel)
            ->setDetailView([$deviceConfigEntryForDetailViewModel])
            ->setAutomation($deviceConfigurationRequestAutomationModel)
            ->setType('test-type')
            ->setDeviceProfileId('test-device-profile-id');

        $serializer = new DeviceConfigurationRequestSerializer($deviceConfigurationIconsItemSerializer, $deviceConfigurationDashboardSerializer, $deviceConfigEntryForDetailViewSerializer, $deviceConfigurationRequestAutomationSerializer);

        self::assertSame(
            [
                DeviceConfigurationRequestSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                DeviceConfigurationRequestSerializerInterface::KEY_ICONS => [['test-serialized-device-configuration-icons-item']],
                DeviceConfigurationRequestSerializerInterface::KEY_DASHBOARD => ['test-serialized-device-configuration-dashboard'],
                DeviceConfigurationRequestSerializerInterface::KEY_DETAIL_VIEW => [['test-serialized-device-config-entry-for-detail-view']],
                DeviceConfigurationRequestSerializerInterface::KEY_AUTOMATION => ['test-serialized-device-configuration-request-automation'],
                DeviceConfigurationRequestSerializerInterface::KEY_TYPE => 'test-type',
                DeviceConfigurationRequestSerializerInterface::KEY_DEVICE_PROFILE_ID => 'test-device-profile-id',
            ],
            $serializer->serialize($model)
        );
    }
}
