<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;
use ChristianBrown\SmartThings\Model\Localization;
use ChristianBrown\SmartThings\Model\LocalizationDetailsInterface;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalizationInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Localization::class)]
#[CoversClass(LocalizationTransformer::class)]
final class LocalizationTransformerExtendedTest extends TestCase
{
    public function testTransformExtendedNestedFields(): void
    {
        $options = [self::createStub(PreferenceOptionLocalizationInterface::class)];
        $attributes = [self::createStub(CapabilityAttributeLocalizationInterface::class)];
        $commands = [self::createStub(CapabilityCommandLocalizationInterface::class)];
        $details = self::createStub(LocalizationDetailsInterface::class);
        $details->method('getOptions')->willReturn($options);
        $details->method('getAttributes')->willReturn($attributes);
        $details->method('getCommands')->willReturn($commands);

        $data = [LocalizationTransformerInterface::KEY_TAG => 'test-tag'] + [LocalizationTransformerInterface::KEY_OPTIONS => []];
        $containerTransformer = self::createMock(LocalizationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new LocalizationTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($options, $actual->getOptions());
        self::assertSame($attributes, $actual->getAttributes());
        self::assertSame($commands, $actual->getCommands());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(LocalizationDetailsInterface::class);
        $containerTransformer = self::createStub(LocalizationDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new LocalizationTransformer($containerTransformer);

        $actual = $transformer->transform([LocalizationTransformerInterface::KEY_TAG => 'test-tag'] + [LocalizationTransformerInterface::KEY_OPTIONS => []]);

        self::assertSame([], $actual->getOptions());
        self::assertSame([], $actual->getAttributes());
        self::assertSame([], $actual->getCommands());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(LocalizationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new LocalizationTransformer($containerTransformer);

        $actual = $transformer->transform([LocalizationTransformerInterface::KEY_TAG => 'test-tag']);

        self::assertSame([], $actual->getOptions());
        self::assertSame([], $actual->getAttributes());
        self::assertSame([], $actual->getCommands());
    }
}
