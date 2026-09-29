<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\GroupVisibleConditions;
use ChristianBrown\SmartThings\Serializer\GroupVisibleConditionsSerializer;
use ChristianBrown\SmartThings\Serializer\GroupVisibleConditionsSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GroupVisibleConditions::class)]
#[CoversClass(GroupVisibleConditionsSerializer::class)]
final class GroupVisibleConditionsSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new GroupVisibleConditions('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability');

        $serializer = new GroupVisibleConditionsSerializer();

        self::assertSame(
            [
                GroupVisibleConditionsSerializerInterface::KEY_VALUE => 'test-value',
                GroupVisibleConditionsSerializerInterface::KEY_OPERATOR => 'test-operator',
                GroupVisibleConditionsSerializerInterface::KEY_OPERAND => 'test-operand',
                GroupVisibleConditionsSerializerInterface::KEY_COMPONENT => 'test-component',
                GroupVisibleConditionsSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new GroupVisibleConditions('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability'))
            ->setValueType('test-value-type')
            ->setVersion(7);

        $serializer = new GroupVisibleConditionsSerializer();

        self::assertSame(
            [
                GroupVisibleConditionsSerializerInterface::KEY_VALUE => 'test-value',
                GroupVisibleConditionsSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                GroupVisibleConditionsSerializerInterface::KEY_OPERATOR => 'test-operator',
                GroupVisibleConditionsSerializerInterface::KEY_OPERAND => 'test-operand',
                GroupVisibleConditionsSerializerInterface::KEY_COMPONENT => 'test-component',
                GroupVisibleConditionsSerializerInterface::KEY_CAPABILITY => 'test-capability',
                GroupVisibleConditionsSerializerInterface::KEY_VERSION => 7,
            ],
            $serializer->serialize($model)
        );
    }
}
