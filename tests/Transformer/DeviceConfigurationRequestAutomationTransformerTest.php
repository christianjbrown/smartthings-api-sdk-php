<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomation;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationRequestAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationRequestAutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationRequestAutomation::class)]
#[CoversClass(DeviceConfigurationRequestAutomationTransformer::class)]
final class DeviceConfigurationRequestAutomationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $data = [
            DeviceConfigurationRequestAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested']],
            DeviceConfigurationRequestAutomationTransformerInterface::KEY_ACTIONS => [['test-nested']],
        ];

        $transformer = new DeviceConfigurationRequestAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$excludedDeviceConditionConfigEntryModel], $actual->getConditions());
        self::assertSame([$excludedDeviceActionConfigEntryModel], $actual->getActions());
    }

    public function testTransformActions(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $transformer = new DeviceConfigurationRequestAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationRequestAutomationTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$excludedDeviceActionConfigEntryModel], $transformer->transform($base + [DeviceConfigurationRequestAutomationTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformConditions(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $transformer = new DeviceConfigurationRequestAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getConditions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationRequestAutomationTransformerInterface::KEY_CONDITIONS => 'test-not-array'])->getConditions());
        self::assertSame([$excludedDeviceConditionConfigEntryModel], $transformer->transform($base + [DeviceConfigurationRequestAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested'], 'test-skipped']])->getConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $transformer = new DeviceConfigurationRequestAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getConditions());
        self::assertNull($actual->getActions());
    }
}
