<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettings;
use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTemperatureConversionsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PresentationSettings::class)]
#[CoversClass(PresentationSettingsTransformer::class)]
final class PresentationSettingsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $presentationSettingsTemperatureConversionsItemModel = self::createStub(PresentationSettingsTemperatureConversionsItemInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer = self::createStub(PresentationSettingsTemperatureConversionsItemTransformerInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer->method('transform')->willReturn($presentationSettingsTemperatureConversionsItemModel);
        $data = [
            PresentationSettingsTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => [['test-nested']],
        ];

        $transformer = new PresentationSettingsTransformer($presentationSettingsTemperatureConversionsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$presentationSettingsTemperatureConversionsItemModel], $actual->getTemperatureConversions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $presentationSettingsTemperatureConversionsItemModel = self::createStub(PresentationSettingsTemperatureConversionsItemInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer = self::createStub(PresentationSettingsTemperatureConversionsItemTransformerInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer->method('transform')->willReturn($presentationSettingsTemperatureConversionsItemModel);
        $transformer = new PresentationSettingsTransformer($presentationSettingsTemperatureConversionsItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getTemperatureConversions());
    }

    public function testTransformTemperatureConversions(): void
    {
        $presentationSettingsTemperatureConversionsItemModel = self::createStub(PresentationSettingsTemperatureConversionsItemInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer = self::createStub(PresentationSettingsTemperatureConversionsItemTransformerInterface::class);
        $presentationSettingsTemperatureConversionsItemTransformer->method('transform')->willReturn($presentationSettingsTemperatureConversionsItemModel);
        $transformer = new PresentationSettingsTransformer($presentationSettingsTemperatureConversionsItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getTemperatureConversions());
        self::assertNull($transformer->transform($base + [PresentationSettingsTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => 'test-not-array'])->getTemperatureConversions());
        self::assertSame([$presentationSettingsTemperatureConversionsItemModel], $transformer->transform($base + [PresentationSettingsTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => [['test-nested'], 'test-skipped']])->getTemperatureConversions());
    }
}
