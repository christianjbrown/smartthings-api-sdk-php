<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationCondition;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationConditionSerializer;
use ChristianBrown\SmartThings\Serializer\TextFieldForAutomationConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextFieldForAutomationCondition::class)]
#[CoversClass(TextFieldForAutomationConditionSerializer::class)]
final class TextFieldForAutomationConditionSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new TextFieldForAutomationCondition('test-value');

        $serializer = new TextFieldForAutomationConditionSerializer();

        self::assertSame(
            [
                TextFieldForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new TextFieldForAutomationCondition('test-value'))
            ->setValueType('test-value-type')
            ->setRange(['test-range-key' => 'test-value']);

        $serializer = new TextFieldForAutomationConditionSerializer();

        self::assertSame(
            [
                TextFieldForAutomationConditionSerializerInterface::KEY_VALUE => 'test-value',
                TextFieldForAutomationConditionSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                TextFieldForAutomationConditionSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
