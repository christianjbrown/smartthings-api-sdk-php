<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SliderForLight;
use ChristianBrown\SmartThings\Transformer\SliderForLightTransformer;
use ChristianBrown\SmartThings\Transformer\SliderForLightTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SliderForLight::class)]
#[CoversClass(SliderForLightTransformer::class)]
final class SliderForLightTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component',
            SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability',
            SliderForLightTransformerInterface::KEY_VERSION => 7,
            SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            SliderForLightTransformerInterface::KEY_STEP => 1.5,
            SliderForLightTransformerInterface::KEY_UNIT => 'test-unit',
            SliderForLightTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
            SliderForLightTransformerInterface::KEY_COMMAND => 'test-command',
            SliderForLightTransformerInterface::KEY_VALUE => 'test-value',
            SliderForLightTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            SliderForLightTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
            SliderForLightTransformerInterface::KEY_LABEL => 'test-label',
        ];

        $transformer = new SliderForLightTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-argument-type', $actual->getArgumentType());
        self::assertSame('test-label', $actual->getLabel());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SliderForLightTransformer();

        $actual = $transformer->transform([SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[SliderForLightTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[SliderForLightTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[SliderForLightTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[SliderForLightTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[SliderForLightTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[SliderForLightTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[SliderForLightTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[SliderForLightTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[SliderForLightTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[SliderForLightTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[SliderForLightTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[SliderForLightTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SliderForLightTransformer();

        $actual = $transformer->transform([SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getStep());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getSupportedValues());
        self::assertNull($actual->getValueType());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new SliderForLightTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'componentAbsent' => [[SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label', SliderForLightTransformerInterface::KEY_COMPONENT => 42], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_COMPONENT)];
        yield 'capabilityAbsent' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label', SliderForLightTransformerInterface::KEY_CAPABILITY => 42], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_CAPABILITY)];
        yield 'rangeAbsent' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForLightTransformerInterface::KEY_RANGE)];
        yield 'rangeWrongType' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label', SliderForLightTransformerInterface::KEY_RANGE => 'not-array'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SliderForLightTransformerInterface::KEY_RANGE)];
        yield 'commandAbsent' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 'test-label', SliderForLightTransformerInterface::KEY_COMMAND => 42], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_COMMAND)];
        yield 'valueAbsent' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_LABEL => 'test-label'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_LABEL => 'test-label', SliderForLightTransformerInterface::KEY_VALUE => 42], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_VALUE)];
        yield 'labelAbsent' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value'], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[SliderForLightTransformerInterface::KEY_COMPONENT => 'test-component', SliderForLightTransformerInterface::KEY_CAPABILITY => 'test-capability', SliderForLightTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'], SliderForLightTransformerInterface::KEY_COMMAND => 'test-command', SliderForLightTransformerInterface::KEY_VALUE => 'test-value', SliderForLightTransformerInterface::KEY_LABEL => 42], sprintf(SliderForLightTransformerInterface::UNEXPECTED_STRING_SPRINTF, SliderForLightTransformerInterface::KEY_LABEL)];
    }
}
