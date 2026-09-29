<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleCondition;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleCondition::class)]
#[CoversClass(VisibleConditionSerializer::class)]
final class VisibleConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new VisibleCondition('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability');

        $serializer = new VisibleConditionSerializer();

        self::assertSame(
            [
                VisibleConditionSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new VisibleCondition('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability'))
            ->setValueType('test-value-type')
            ->setVersion(7);

        $serializer = new VisibleConditionSerializer();

        self::assertSame(
            [
                VisibleConditionSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                VisibleConditionSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionSerializerInterface::KEY_CAPABILITY => 'test-capability',
                VisibleConditionSerializerInterface::KEY_VERSION => 7,
            ],
            $serializer->serialize($model)
        );
    }
}
