<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionBase;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionBaseSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionBase::class)]
#[CoversClass(VisibleConditionBaseSerializer::class)]
final class VisibleConditionBaseSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new VisibleConditionBase('test-value', 'test-operator', 'test-operand');

        $serializer = new VisibleConditionBaseSerializer();

        self::assertSame(
            [
                VisibleConditionBaseSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionBaseSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionBaseSerializerInterface::KEY_OPERAND => 'test-operand',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new VisibleConditionBase('test-value', 'test-operator', 'test-operand'))
            ->setValueType('test-value-type');

        $serializer = new VisibleConditionBaseSerializer();

        self::assertSame(
            [
                VisibleConditionBaseSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionBaseSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                VisibleConditionBaseSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionBaseSerializerInterface::KEY_OPERAND => 'test-operand',
            ],
            $serializer->serialize($model)
        );
    }
}
