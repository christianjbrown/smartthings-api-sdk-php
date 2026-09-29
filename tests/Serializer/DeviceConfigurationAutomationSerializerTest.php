<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomation;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Serializer\DescriptionsInAutomationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationAutomationSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceActionConfigEntrySerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedDeviceConditionConfigEntrySerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationAutomation::class)]
#[CoversClass(DeviceConfigurationAutomationSerializer::class)]
final class DeviceConfigurationAutomationSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntrySerializer = self::createStub(ExcludedDeviceConditionConfigEntrySerializerInterface::class);
        $excludedDeviceConditionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-condition-config-entry']);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntrySerializer = self::createStub(ExcludedDeviceActionConfigEntrySerializerInterface::class);
        $excludedDeviceActionConfigEntrySerializer->method('serialize')->willReturn(['test-serialized-excluded-device-action-config-entry']);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationSerializer = self::createStub(DescriptionsInAutomationSerializerInterface::class);
        $descriptionsInAutomationSerializer->method('serialize')->willReturn(['test-serialized-descriptions-in-automation']);
        $model = new DeviceConfigurationAutomation();

        $serializer = new DeviceConfigurationAutomationSerializer($excludedDeviceConditionConfigEntrySerializer, $excludedDeviceActionConfigEntrySerializer, $descriptionsInAutomationSerializer);

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
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationSerializer = self::createStub(DescriptionsInAutomationSerializerInterface::class);
        $descriptionsInAutomationSerializer->method('serialize')->willReturn(['test-serialized-descriptions-in-automation']);
        $model = (new DeviceConfigurationAutomation())
            ->setConditions([$excludedDeviceConditionConfigEntryModel])
            ->setActions([$excludedDeviceActionConfigEntryModel])
            ->setDescriptions($descriptionsInAutomationModel);

        $serializer = new DeviceConfigurationAutomationSerializer($excludedDeviceConditionConfigEntrySerializer, $excludedDeviceActionConfigEntrySerializer, $descriptionsInAutomationSerializer);

        self::assertSame(
            [
                DeviceConfigurationAutomationSerializerInterface::KEY_CONDITIONS => [['test-serialized-excluded-device-condition-config-entry']],
                DeviceConfigurationAutomationSerializerInterface::KEY_ACTIONS => [['test-serialized-excluded-device-action-config-entry']],
                DeviceConfigurationAutomationSerializerInterface::KEY_DESCRIPTIONS => ['test-serialized-descriptions-in-automation'],
            ],
            $serializer->serialize($model)
        );
    }
}
