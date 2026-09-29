<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsForDevicePresentation;
use ChristianBrown\SmartThings\Model\TemperatureConversionsItemForDevicePresentationInterface;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsForDevicePresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TemperatureConversionsItemForDevicePresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PresentationSettingsForDevicePresentation::class)]
#[CoversClass(PresentationSettingsForDevicePresentationTransformer::class)]
final class PresentationSettingsForDevicePresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $temperatureConversionsItemForDevicePresentationModel = self::createStub(TemperatureConversionsItemForDevicePresentationInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer = self::createStub(TemperatureConversionsItemForDevicePresentationTransformerInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer->method('transform')->willReturn($temperatureConversionsItemForDevicePresentationModel);
        $data = [
            PresentationSettingsForDevicePresentationTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => [['test-nested']],
        ];

        $transformer = new PresentationSettingsForDevicePresentationTransformer($temperatureConversionsItemForDevicePresentationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$temperatureConversionsItemForDevicePresentationModel], $actual->getTemperatureConversions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $temperatureConversionsItemForDevicePresentationModel = self::createStub(TemperatureConversionsItemForDevicePresentationInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer = self::createStub(TemperatureConversionsItemForDevicePresentationTransformerInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer->method('transform')->willReturn($temperatureConversionsItemForDevicePresentationModel);
        $transformer = new PresentationSettingsForDevicePresentationTransformer($temperatureConversionsItemForDevicePresentationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getTemperatureConversions());
    }

    public function testTransformTemperatureConversions(): void
    {
        $temperatureConversionsItemForDevicePresentationModel = self::createStub(TemperatureConversionsItemForDevicePresentationInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer = self::createStub(TemperatureConversionsItemForDevicePresentationTransformerInterface::class);
        $temperatureConversionsItemForDevicePresentationTransformer->method('transform')->willReturn($temperatureConversionsItemForDevicePresentationModel);
        $transformer = new PresentationSettingsForDevicePresentationTransformer($temperatureConversionsItemForDevicePresentationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getTemperatureConversions());
        self::assertNull($transformer->transform($base + [PresentationSettingsForDevicePresentationTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => 'test-not-array'])->getTemperatureConversions());
        self::assertSame([$temperatureConversionsItemForDevicePresentationModel], $transformer->transform($base + [PresentationSettingsForDevicePresentationTransformerInterface::KEY_TEMPERATURE_CONVERSIONS => [['test-nested'], 'test-skipped']])->getTemperatureConversions());
    }
}
