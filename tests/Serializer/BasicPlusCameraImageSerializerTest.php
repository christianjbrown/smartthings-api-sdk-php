<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImage;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraImageSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraImageSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCameraImage::class)]
#[CoversClass(BasicPlusCameraImageSerializer::class)]
final class BasicPlusCameraImageSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new BasicPlusCameraImage('test-capability', 'test-component', 'test-value');

        $serializer = new BasicPlusCameraImageSerializer();

        self::assertSame(
            [
                BasicPlusCameraImageSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusCameraImageSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusCameraImageSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new BasicPlusCameraImage('test-capability', 'test-component', 'test-value'))
            ->setVersion(7);

        $serializer = new BasicPlusCameraImageSerializer();

        self::assertSame(
            [
                BasicPlusCameraImageSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusCameraImageSerializerInterface::KEY_VERSION => 7,
                BasicPlusCameraImageSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusCameraImageSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }
}
