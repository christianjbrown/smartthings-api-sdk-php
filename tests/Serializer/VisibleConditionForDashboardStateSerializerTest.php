<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardState;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDashboardStateSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDashboardStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForDashboardState::class)]
#[CoversClass(VisibleConditionForDashboardStateSerializer::class)]
final class VisibleConditionForDashboardStateSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new VisibleConditionForDashboardState('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability');

        $serializer = new VisibleConditionForDashboardStateSerializer();

        self::assertSame(
            [
                VisibleConditionForDashboardStateSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionForDashboardStateSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForDashboardStateSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionForDashboardStateSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForDashboardStateSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new VisibleConditionForDashboardState('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability'))
            ->setValueType('test-value-type')
            ->setVersion(7)
            ->setIsOffline(true);

        $serializer = new VisibleConditionForDashboardStateSerializer();

        self::assertSame(
            [
                VisibleConditionForDashboardStateSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionForDashboardStateSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                VisibleConditionForDashboardStateSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForDashboardStateSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionForDashboardStateSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForDashboardStateSerializerInterface::KEY_CAPABILITY => 'test-capability',
                VisibleConditionForDashboardStateSerializerInterface::KEY_VERSION => 7,
                VisibleConditionForDashboardStateSerializerInterface::KEY_IS_OFFLINE => true,
            ],
            $serializer->serialize($model)
        );
    }
}
