<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItem;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializer;
use ChristianBrown\SmartThings\Serializer\EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumSliderForAutomationConditionSupportedOperatorsItem::class)]
#[CoversClass(EnumSliderForAutomationConditionSupportedOperatorsItemSerializer::class)]
final class EnumSliderForAutomationConditionSupportedOperatorsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new EnumSliderForAutomationConditionSupportedOperatorsItem('test-operator', 'test-label');

        $serializer = new EnumSliderForAutomationConditionSupportedOperatorsItemSerializer();

        self::assertSame(
            [
                EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }
}
