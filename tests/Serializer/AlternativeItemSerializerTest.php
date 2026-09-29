<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItem;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializer;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AlternativeItem::class)]
#[CoversClass(AlternativeItemSerializer::class)]
final class AlternativeItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new AlternativeItem('test-key', 'test-value');

        $serializer = new AlternativeItemSerializer();

        self::assertSame(
            [
                AlternativeItemSerializerInterface::KEY_KEY => 'test-key',
                AlternativeItemSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new AlternativeItem('test-key', 'test-value'))
            ->setType('test-type')
            ->setIconUrl('test-icon-url')
            ->setDescription('test-description');

        $serializer = new AlternativeItemSerializer();

        self::assertSame(
            [
                AlternativeItemSerializerInterface::KEY_KEY => 'test-key',
                AlternativeItemSerializerInterface::KEY_VALUE => 'test-value',
                AlternativeItemSerializerInterface::KEY_TYPE => 'test-type',
                AlternativeItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                AlternativeItemSerializerInterface::KEY_DESCRIPTION => 'test-description',
            ],
            $serializer->serialize($model)
        );
    }
}
