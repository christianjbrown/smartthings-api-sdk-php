<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfiguration;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigEntryForDetailViewSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationAutomationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDashboardSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfosItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfiguration::class)]
#[CoversClass(DeviceConfigurationSerializer::class)]
final class DeviceConfigurationSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemSerializer = self::createStub(DeviceConfigurationDpInfoItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item']);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemSerializer = self::createStub(DeviceConfigurationDpInfosItemSerializerInterface::class);
        $deviceConfigurationDpInfosItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-infos-item']);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemSerializer = self::createStub(DeviceConfigurationIconsItemSerializerInterface::class);
        $deviceConfigurationIconsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item']);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardSerializer = self::createStub(DeviceConfigurationDashboardSerializerInterface::class);
        $deviceConfigurationDashboardSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dashboard']);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewSerializer = self::createStub(DeviceConfigEntryForDetailViewSerializerInterface::class);
        $deviceConfigEntryForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-detail-view']);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationSerializer = self::createStub(DeviceConfigurationAutomationSerializerInterface::class);
        $deviceConfigurationAutomationSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-automation']);
        $model = new DeviceConfiguration('test-mnmn', 'test-vid');

        $serializer = new DeviceConfigurationSerializer($deviceConfigurationDpInfoItemSerializer, $deviceConfigurationDpInfosItemSerializer, $deviceConfigurationIconsItemSerializer, $deviceConfigurationDashboardSerializer, $deviceConfigEntryForDetailViewSerializer, $deviceConfigurationAutomationSerializer);

        self::assertSame(
            [
                DeviceConfigurationSerializerInterface::KEY_MNMN => 'test-mnmn',
                DeviceConfigurationSerializerInterface::KEY_VID => 'test-vid',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemSerializer = self::createStub(DeviceConfigurationDpInfoItemSerializerInterface::class);
        $deviceConfigurationDpInfoItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-info-item']);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemSerializer = self::createStub(DeviceConfigurationDpInfosItemSerializerInterface::class);
        $deviceConfigurationDpInfosItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dp-infos-item']);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemSerializer = self::createStub(DeviceConfigurationIconsItemSerializerInterface::class);
        $deviceConfigurationIconsItemSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-icons-item']);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardSerializer = self::createStub(DeviceConfigurationDashboardSerializerInterface::class);
        $deviceConfigurationDashboardSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-dashboard']);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewSerializer = self::createStub(DeviceConfigEntryForDetailViewSerializerInterface::class);
        $deviceConfigEntryForDetailViewSerializer->method('serialize')->willReturn(['test-serialized-device-config-entry-for-detail-view']);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationSerializer = self::createStub(DeviceConfigurationAutomationSerializerInterface::class);
        $deviceConfigurationAutomationSerializer->method('serialize')->willReturn(['test-serialized-device-configuration-automation']);
        $model = (new DeviceConfiguration('test-mnmn', 'test-vid'))
            ->setVersion('test-version')
            ->setDescription('test-description')
            ->setType('test-type')
            ->setDpInfo([$deviceConfigurationDpInfoItemModel])
            ->setDpInfos([$deviceConfigurationDpInfosItemModel])
            ->setIconUrl('test-icon-url')
            ->setIcons([$deviceConfigurationIconsItemModel])
            ->setDashboard($deviceConfigurationDashboardModel)
            ->setDetailView([$deviceConfigEntryForDetailViewModel])
            ->setAutomation($deviceConfigurationAutomationModel)
            ->setPresentationId('test-presentation-id')
            ->setManufacturerName('test-manufacturer-name');

        $serializer = new DeviceConfigurationSerializer($deviceConfigurationDpInfoItemSerializer, $deviceConfigurationDpInfosItemSerializer, $deviceConfigurationIconsItemSerializer, $deviceConfigurationDashboardSerializer, $deviceConfigEntryForDetailViewSerializer, $deviceConfigurationAutomationSerializer);

        self::assertSame(
            [
                DeviceConfigurationSerializerInterface::KEY_MNMN => 'test-mnmn',
                DeviceConfigurationSerializerInterface::KEY_VID => 'test-vid',
                DeviceConfigurationSerializerInterface::KEY_VERSION => 'test-version',
                DeviceConfigurationSerializerInterface::KEY_DESCRIPTION => 'test-description',
                DeviceConfigurationSerializerInterface::KEY_TYPE => 'test-type',
                DeviceConfigurationSerializerInterface::KEY_DP_INFO => [['test-serialized-device-configuration-dp-info-item']],
                DeviceConfigurationSerializerInterface::KEY_DP_INFOS => [['test-serialized-device-configuration-dp-infos-item']],
                DeviceConfigurationSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                DeviceConfigurationSerializerInterface::KEY_ICONS => [['test-serialized-device-configuration-icons-item']],
                DeviceConfigurationSerializerInterface::KEY_DASHBOARD => ['test-serialized-device-configuration-dashboard'],
                DeviceConfigurationSerializerInterface::KEY_DETAIL_VIEW => [['test-serialized-device-config-entry-for-detail-view']],
                DeviceConfigurationSerializerInterface::KEY_AUTOMATION => ['test-serialized-device-configuration-automation'],
                DeviceConfigurationSerializerInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
                DeviceConfigurationSerializerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name',
            ],
            $serializer->serialize($model)
        );
    }
}
