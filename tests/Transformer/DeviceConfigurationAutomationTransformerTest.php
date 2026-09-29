<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomation;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationAutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceActionConfigEntryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedDeviceConditionConfigEntryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationAutomation::class)]
#[CoversClass(DeviceConfigurationAutomationTransformer::class)]
final class DeviceConfigurationAutomationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $data = [
            DeviceConfigurationAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested']],
            DeviceConfigurationAutomationTransformerInterface::KEY_ACTIONS => [['test-nested']],
            DeviceConfigurationAutomationTransformerInterface::KEY_DESCRIPTIONS => ['test-nested'],
        ];

        $transformer = new DeviceConfigurationAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer, $descriptionsInAutomationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$excludedDeviceConditionConfigEntryModel], $actual->getConditions());
        self::assertSame([$excludedDeviceActionConfigEntryModel], $actual->getActions());
        self::assertSame($descriptionsInAutomationModel, $actual->getDescriptions());
    }

    public function testTransformActions(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new DeviceConfigurationAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$excludedDeviceActionConfigEntryModel], $transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformConditions(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new DeviceConfigurationAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getConditions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_CONDITIONS => 'test-not-array'])->getConditions());
        self::assertSame([$excludedDeviceConditionConfigEntryModel], $transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested'], 'test-skipped']])->getConditions());
    }

    public function testTransformDescriptions(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new DeviceConfigurationAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer, $descriptionsInAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDescriptions());
        self::assertNull($transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_DESCRIPTIONS => 'test-not-array'])->getDescriptions());
        self::assertSame($descriptionsInAutomationModel, $transformer->transform($base + [DeviceConfigurationAutomationTransformerInterface::KEY_DESCRIPTIONS => ['test-nested']])->getDescriptions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedDeviceConditionConfigEntryModel = self::createStub(ExcludedDeviceConditionConfigEntryInterface::class);
        $excludedDeviceConditionConfigEntryTransformer = self::createStub(ExcludedDeviceConditionConfigEntryTransformerInterface::class);
        $excludedDeviceConditionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceConditionConfigEntryModel);
        $excludedDeviceActionConfigEntryModel = self::createStub(ExcludedDeviceActionConfigEntryInterface::class);
        $excludedDeviceActionConfigEntryTransformer = self::createStub(ExcludedDeviceActionConfigEntryTransformerInterface::class);
        $excludedDeviceActionConfigEntryTransformer->method('transform')->willReturn($excludedDeviceActionConfigEntryModel);
        $descriptionsInAutomationModel = self::createStub(DescriptionsInAutomationInterface::class);
        $descriptionsInAutomationTransformer = self::createStub(DescriptionsInAutomationTransformerInterface::class);
        $descriptionsInAutomationTransformer->method('transform')->willReturn($descriptionsInAutomationModel);
        $transformer = new DeviceConfigurationAutomationTransformer($excludedDeviceConditionConfigEntryTransformer, $excludedDeviceActionConfigEntryTransformer, $descriptionsInAutomationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getConditions());
        self::assertNull($actual->getActions());
        self::assertNull($actual->getDescriptions());
    }
}
