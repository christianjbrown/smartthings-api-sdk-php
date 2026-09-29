<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;
use ChristianBrown\SmartThings\Model\LocalizationDetails;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalizationInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLocalizationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandLocalizationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocalizationDetails::class)]
#[CoversClass(LocalizationDetailsTransformer::class)]
final class LocalizationDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $preferenceOptionLocalizationModel = self::createStub(PreferenceOptionLocalizationInterface::class);
        $preferenceOptionLocalizationTransformer = self::createStub(PreferenceOptionLocalizationTransformerInterface::class);
        $preferenceOptionLocalizationTransformer->method('transform')->willReturn($preferenceOptionLocalizationModel);
        $capabilityAttributeLocalizationModel = self::createStub(CapabilityAttributeLocalizationInterface::class);
        $capabilityAttributeLocalizationTransformer = self::createStub(CapabilityAttributeLocalizationTransformerInterface::class);
        $capabilityAttributeLocalizationTransformer->method('transform')->willReturn($capabilityAttributeLocalizationModel);
        $capabilityCommandLocalizationModel = self::createStub(CapabilityCommandLocalizationInterface::class);
        $capabilityCommandLocalizationTransformer = self::createStub(CapabilityCommandLocalizationTransformerInterface::class);
        $capabilityCommandLocalizationTransformer->method('transform')->willReturn($capabilityCommandLocalizationModel);
        $data = [
            LocalizationDetailsTransformerInterface::KEY_OPTIONS => ['test-key' => ['test-nested']],
            LocalizationDetailsTransformerInterface::KEY_ATTRIBUTES => ['test-key' => ['test-nested']],
            LocalizationDetailsTransformerInterface::KEY_COMMANDS => ['test-key' => ['test-nested']],
        ];

        $transformer = new LocalizationDetailsTransformer($preferenceOptionLocalizationTransformer, $capabilityAttributeLocalizationTransformer, $capabilityCommandLocalizationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-key' => $preferenceOptionLocalizationModel], $actual->getOptions());
        self::assertSame(['test-key' => $capabilityAttributeLocalizationModel], $actual->getAttributes());
        self::assertSame(['test-key' => $capabilityCommandLocalizationModel], $actual->getCommands());
    }

    public function testTransformAttributes(): void
    {
        $preferenceOptionLocalizationModel = self::createStub(PreferenceOptionLocalizationInterface::class);
        $preferenceOptionLocalizationTransformer = self::createStub(PreferenceOptionLocalizationTransformerInterface::class);
        $preferenceOptionLocalizationTransformer->method('transform')->willReturn($preferenceOptionLocalizationModel);
        $capabilityAttributeLocalizationModel = self::createStub(CapabilityAttributeLocalizationInterface::class);
        $capabilityAttributeLocalizationTransformer = self::createStub(CapabilityAttributeLocalizationTransformerInterface::class);
        $capabilityAttributeLocalizationTransformer->method('transform')->willReturn($capabilityAttributeLocalizationModel);
        $capabilityCommandLocalizationModel = self::createStub(CapabilityCommandLocalizationInterface::class);
        $capabilityCommandLocalizationTransformer = self::createStub(CapabilityCommandLocalizationTransformerInterface::class);
        $capabilityCommandLocalizationTransformer->method('transform')->willReturn($capabilityCommandLocalizationModel);
        $transformer = new LocalizationDetailsTransformer($preferenceOptionLocalizationTransformer, $capabilityAttributeLocalizationTransformer, $capabilityCommandLocalizationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAttributes());
        self::assertNull($transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_ATTRIBUTES => 'test-not-array'])->getAttributes());
        self::assertSame(['test-key' => $capabilityAttributeLocalizationModel], $transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_ATTRIBUTES => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getAttributes());
    }

    public function testTransformCommands(): void
    {
        $preferenceOptionLocalizationModel = self::createStub(PreferenceOptionLocalizationInterface::class);
        $preferenceOptionLocalizationTransformer = self::createStub(PreferenceOptionLocalizationTransformerInterface::class);
        $preferenceOptionLocalizationTransformer->method('transform')->willReturn($preferenceOptionLocalizationModel);
        $capabilityAttributeLocalizationModel = self::createStub(CapabilityAttributeLocalizationInterface::class);
        $capabilityAttributeLocalizationTransformer = self::createStub(CapabilityAttributeLocalizationTransformerInterface::class);
        $capabilityAttributeLocalizationTransformer->method('transform')->willReturn($capabilityAttributeLocalizationModel);
        $capabilityCommandLocalizationModel = self::createStub(CapabilityCommandLocalizationInterface::class);
        $capabilityCommandLocalizationTransformer = self::createStub(CapabilityCommandLocalizationTransformerInterface::class);
        $capabilityCommandLocalizationTransformer->method('transform')->willReturn($capabilityCommandLocalizationModel);
        $transformer = new LocalizationDetailsTransformer($preferenceOptionLocalizationTransformer, $capabilityAttributeLocalizationTransformer, $capabilityCommandLocalizationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCommands());
        self::assertNull($transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_COMMANDS => 'test-not-array'])->getCommands());
        self::assertSame(['test-key' => $capabilityCommandLocalizationModel], $transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_COMMANDS => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getCommands());
    }

    public function testTransformOptions(): void
    {
        $preferenceOptionLocalizationModel = self::createStub(PreferenceOptionLocalizationInterface::class);
        $preferenceOptionLocalizationTransformer = self::createStub(PreferenceOptionLocalizationTransformerInterface::class);
        $preferenceOptionLocalizationTransformer->method('transform')->willReturn($preferenceOptionLocalizationModel);
        $capabilityAttributeLocalizationModel = self::createStub(CapabilityAttributeLocalizationInterface::class);
        $capabilityAttributeLocalizationTransformer = self::createStub(CapabilityAttributeLocalizationTransformerInterface::class);
        $capabilityAttributeLocalizationTransformer->method('transform')->willReturn($capabilityAttributeLocalizationModel);
        $capabilityCommandLocalizationModel = self::createStub(CapabilityCommandLocalizationInterface::class);
        $capabilityCommandLocalizationTransformer = self::createStub(CapabilityCommandLocalizationTransformerInterface::class);
        $capabilityCommandLocalizationTransformer->method('transform')->willReturn($capabilityCommandLocalizationModel);
        $transformer = new LocalizationDetailsTransformer($preferenceOptionLocalizationTransformer, $capabilityAttributeLocalizationTransformer, $capabilityCommandLocalizationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getOptions());
        self::assertNull($transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_OPTIONS => 'test-not-array'])->getOptions());
        self::assertSame(['test-key' => $preferenceOptionLocalizationModel], $transformer->transform($base + [LocalizationDetailsTransformerInterface::KEY_OPTIONS => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getOptions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $preferenceOptionLocalizationModel = self::createStub(PreferenceOptionLocalizationInterface::class);
        $preferenceOptionLocalizationTransformer = self::createStub(PreferenceOptionLocalizationTransformerInterface::class);
        $preferenceOptionLocalizationTransformer->method('transform')->willReturn($preferenceOptionLocalizationModel);
        $capabilityAttributeLocalizationModel = self::createStub(CapabilityAttributeLocalizationInterface::class);
        $capabilityAttributeLocalizationTransformer = self::createStub(CapabilityAttributeLocalizationTransformerInterface::class);
        $capabilityAttributeLocalizationTransformer->method('transform')->willReturn($capabilityAttributeLocalizationModel);
        $capabilityCommandLocalizationModel = self::createStub(CapabilityCommandLocalizationInterface::class);
        $capabilityCommandLocalizationTransformer = self::createStub(CapabilityCommandLocalizationTransformerInterface::class);
        $capabilityCommandLocalizationTransformer->method('transform')->willReturn($capabilityCommandLocalizationModel);
        $transformer = new LocalizationDetailsTransformer($preferenceOptionLocalizationTransformer, $capabilityAttributeLocalizationTransformer, $capabilityCommandLocalizationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getOptions());
        self::assertNull($actual->getAttributes());
        self::assertNull($actual->getCommands());
    }
}
