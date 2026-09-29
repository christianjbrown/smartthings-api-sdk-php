<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\SliderForLight;
use ChristianBrown\SmartThings\Serializer\SliderForLightSerializer;
use ChristianBrown\SmartThings\Serializer\SliderForLightSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SliderForLight::class)]
#[CoversClass(SliderForLightSerializer::class)]
final class SliderForLightSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new SliderForLight('test-component', 'test-capability', ['test-range-key' => 'test-value'], 'test-command', 'test-value', 'test-label');

        $serializer = new SliderForLightSerializer();

        self::assertSame(
            [
                SliderForLightSerializerInterface::KEY_COMPONENT => 'test-component',
                SliderForLightSerializerInterface::KEY_CAPABILITY => 'test-capability',
                SliderForLightSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForLightSerializerInterface::KEY_COMMAND => 'test-command',
                SliderForLightSerializerInterface::KEY_VALUE => 'test-value',
                SliderForLightSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new SliderForLight('test-component', 'test-capability', ['test-range-key' => 'test-value'], 'test-command', 'test-value', 'test-label'))
            ->setVersion(7)
            ->setStep(1.5)
            ->setUnit('test-unit')
            ->setSupportedValues('test-supported-values')
            ->setValueType('test-value-type')
            ->setArgumentType('test-argument-type');

        $serializer = new SliderForLightSerializer();

        self::assertSame(
            [
                SliderForLightSerializerInterface::KEY_COMPONENT => 'test-component',
                SliderForLightSerializerInterface::KEY_CAPABILITY => 'test-capability',
                SliderForLightSerializerInterface::KEY_VERSION => 7,
                SliderForLightSerializerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
                SliderForLightSerializerInterface::KEY_STEP => 1.5,
                SliderForLightSerializerInterface::KEY_UNIT => 'test-unit',
                SliderForLightSerializerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
                SliderForLightSerializerInterface::KEY_COMMAND => 'test-command',
                SliderForLightSerializerInterface::KEY_VALUE => 'test-value',
                SliderForLightSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                SliderForLightSerializerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
                SliderForLightSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }
}
