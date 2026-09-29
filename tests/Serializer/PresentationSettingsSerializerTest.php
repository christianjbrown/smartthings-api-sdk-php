<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettings;
use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsTemperatureConversionsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PresentationSettings::class)]
#[CoversClass(PresentationSettingsSerializer::class)]
final class PresentationSettingsSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $presentationSettingsTemperatureConversionsItemModel = self::createStub(PresentationSettingsTemperatureConversionsItemInterface::class);
        $presentationSettingsTemperatureConversionsItemSerializer = self::createStub(PresentationSettingsTemperatureConversionsItemSerializerInterface::class);
        $presentationSettingsTemperatureConversionsItemSerializer->method('serialize')->willReturn(['test-serialized-presentation-settings-temperature-conversions-item']);
        $model = new PresentationSettings();

        $serializer = new PresentationSettingsSerializer($presentationSettingsTemperatureConversionsItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $presentationSettingsTemperatureConversionsItemModel = self::createStub(PresentationSettingsTemperatureConversionsItemInterface::class);
        $presentationSettingsTemperatureConversionsItemSerializer = self::createStub(PresentationSettingsTemperatureConversionsItemSerializerInterface::class);
        $presentationSettingsTemperatureConversionsItemSerializer->method('serialize')->willReturn(['test-serialized-presentation-settings-temperature-conversions-item']);
        $model = (new PresentationSettings())
            ->setTemperatureConversions([$presentationSettingsTemperatureConversionsItemModel]);

        $serializer = new PresentationSettingsSerializer($presentationSettingsTemperatureConversionsItemSerializer);

        self::assertSame(
            [
                PresentationSettingsSerializerInterface::KEY_TEMPERATURE_CONVERSIONS => [['test-serialized-presentation-settings-temperature-conversions-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
