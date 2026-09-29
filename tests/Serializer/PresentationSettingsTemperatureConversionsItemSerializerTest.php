<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItem;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsTemperatureConversionsItemSerializer;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsTemperatureConversionsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PresentationSettingsTemperatureConversionsItem::class)]
#[CoversClass(PresentationSettingsTemperatureConversionsItemSerializer::class)]
final class PresentationSettingsTemperatureConversionsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PresentationSettingsTemperatureConversionsItem('test-value');

        $serializer = new PresentationSettingsTemperatureConversionsItemSerializer();

        self::assertSame(
            [
                PresentationSettingsTemperatureConversionsItemSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PresentationSettingsTemperatureConversionsItem('test-value'))
            ->setUnit('test-unit');

        $serializer = new PresentationSettingsTemperatureConversionsItemSerializer();

        self::assertSame(
            [
                PresentationSettingsTemperatureConversionsItemSerializerInterface::KEY_VALUE => 'test-value',
                PresentationSettingsTemperatureConversionsItemSerializerInterface::KEY_UNIT => 'test-unit',
            ],
            $serializer->serialize($model)
        );
    }
}
