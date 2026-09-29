<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\IndoorMap;
use ChristianBrown\SmartThings\Serializer\IndoorMapSerializer;
use ChristianBrown\SmartThings\Serializer\IndoorMapSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IndoorMap::class)]
#[CoversClass(IndoorMapSerializer::class)]
final class IndoorMapSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new IndoorMap();

        $serializer = new IndoorMapSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new IndoorMap())
            ->setCoordinates(['test-coordinates-key' => 'test-value'])
            ->setRotation(['test-rotation-key' => 'test-value'])
            ->setVisible(true)
            ->setData(['test-data-key' => 'test-value']);

        $serializer = new IndoorMapSerializer();

        self::assertSame(
            [
                IndoorMapSerializerInterface::KEY_COORDINATES => ['test-coordinates-key' => 'test-value'],
                IndoorMapSerializerInterface::KEY_ROTATION => ['test-rotation-key' => 'test-value'],
                IndoorMapSerializerInterface::KEY_VISIBLE => true,
                IndoorMapSerializerInterface::KEY_DATA => ['test-data-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
