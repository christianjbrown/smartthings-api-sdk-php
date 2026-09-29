<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItem;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsBarItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsBarItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusProgressBarsBarItem::class)]
#[CoversClass(BasicPlusProgressBarsBarItemSerializer::class)]
final class BasicPlusProgressBarsBarItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new BasicPlusProgressBarsBarItem('test-capability', 'test-component', 'test-value');

        $serializer = new BasicPlusProgressBarsBarItemSerializer();

        self::assertSame(
            [
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new BasicPlusProgressBarsBarItem('test-capability', 'test-component', 'test-value'))
            ->setVersion(7)
            ->setValueType('test-value-type')
            ->setRange(['test-range-key' => 'test-value']);

        $serializer = new BasicPlusProgressBarsBarItemSerializer();

        self::assertSame(
            [
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_VERSION => 7,
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                BasicPlusProgressBarsBarItemSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
