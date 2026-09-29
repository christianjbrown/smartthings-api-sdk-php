<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferTo;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemReferToSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemReferToSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForColorItemReferTo::class)]
#[CoversClass(VisibleConditionForColorItemReferToSerializer::class)]
final class VisibleConditionForColorItemReferToSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new VisibleConditionForColorItemReferTo('test-component', 'test-capability', 'test-value');

        $serializer = new VisibleConditionForColorItemReferToSerializer();

        self::assertSame(
            [
                VisibleConditionForColorItemReferToSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForColorItemReferToSerializerInterface::KEY_CAPABILITY => 'test-capability',
                VisibleConditionForColorItemReferToSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new VisibleConditionForColorItemReferTo('test-component', 'test-capability', 'test-value'))
            ->setVersion(7)
            ->setValueType('test-value-type');

        $serializer = new VisibleConditionForColorItemReferToSerializer();

        self::assertSame(
            [
                VisibleConditionForColorItemReferToSerializerInterface::KEY_COMPONENT => 'test-component',
                VisibleConditionForColorItemReferToSerializerInterface::KEY_CAPABILITY => 'test-capability',
                VisibleConditionForColorItemReferToSerializerInterface::KEY_VERSION => 7,
                VisibleConditionForColorItemReferToSerializerInterface::KEY_VALUE => 'test-value',
                VisibleConditionForColorItemReferToSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
            ],
            $serializer->serialize($model)
        );
    }
}
