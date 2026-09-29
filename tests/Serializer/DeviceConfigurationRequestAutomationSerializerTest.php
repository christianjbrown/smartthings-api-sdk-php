<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomation;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestAutomationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationRequestAutomation::class)]
#[CoversClass(DeviceConfigurationRequestAutomationSerializer::class)]
final class DeviceConfigurationRequestAutomationSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntrySerializer = self::createStub(ExcludedDeviceConditionConfigEntrySerializerInterface::class);
        $excludedDeviceConditionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-condition-config-entry']);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntrySerializer = self::createStub(ExcludedDeviceActionConfigEntrySerializerInterface::class);
        $excludedDeviceActionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-action-config-entry']);
        $model = new DeviceConfigurationRequestAutomation();

        $serializer = new DeviceConfigurationRequestAutomationSerializer($excludedDeviceConditionConfigEntrySerializer, $excludedDeviceActionConfigEntrySerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntrySerializer = self::createStub(ExcludedDeviceConditionConfigEntrySerializerInterface::class);
        $excludedDeviceConditionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-condition-config-entry']);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntrySerializer = self::createStub(ExcludedDeviceActionConfigEntrySerializerInterface::class);
        $excludedDeviceActionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-action-config-entry']);
        $model = (new DeviceConfigurationRequestAutomation())
            ->setConditions([$excludedDeviceConditionConfigEntryModel])
            ->setActions([$excludedDeviceActionConfigEntryModel]);

        $serializer = new DeviceConfigurationRequestAutomationSerializer($excludedDeviceConditionConfigEntrySerializer, $excludedDeviceActionConfigEntrySerializer);

        self::assertSame(
            [
                DeviceConfigurationRequestAutomationSerializerInterface::KEY_CONDITIONS => [['test-serialized-excluded-device-condition-config-entry']],
                DeviceConfigurationRequestAutomationSerializerInterface::KEY_ACTIONS => [['test-serialized-excluded-device-action-config-entry']],
            ],
            $serializer->serialize($model)
        );
    }
}
