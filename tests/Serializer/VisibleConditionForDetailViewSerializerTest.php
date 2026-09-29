<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDetailView;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForDetailViewSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForDetailView::class)]
#[CoversClass(VisibleConditionForDetailViewSerializer::class)]
final class VisibleConditionForDetailViewSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new VisibleConditionForDetailView('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability');

        $serializer = new VisibleConditionForDetailViewSerializer();

        self::assertSame(
            [
                VisibleConditionForDetailViewSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionForDetailViewSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForDetailViewSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionForDetailViewSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForDetailViewSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new VisibleConditionForDetailView('test-value', 'test-operator', 'test-operand', 'test-component', 'test-capability'))
            ->setValueType('test-value-type')
            ->setVersion(7)
            ->setHideOnUnmatch(true);

        $serializer = new VisibleConditionForDetailViewSerializer();

        self::assertSame(
            [
                VisibleConditionForDetailViewSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionForDetailViewSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                VisibleConditionForDetailViewSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForDetailViewSerializerInterface::KEY_OPERAND => 'test-operand',
                VisibleConditionForDetailViewSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForDetailViewSerializerInterface::KEY_CAPABILITY => 'test-capability',
                VisibleConditionForDetailViewSerializerInterface::KEY_VERSION => 7,
                VisibleConditionForDetailViewSerializerInterface::KEY_HIDE_ON_UNMATCH => true,
            ],
            $serializer->serialize($model)
        );
    }
}
