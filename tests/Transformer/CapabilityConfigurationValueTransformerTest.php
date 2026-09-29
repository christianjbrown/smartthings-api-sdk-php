<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValue;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityConfigurationValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityConfigurationValue::class)]
#[CoversClass(CapabilityConfigurationValueTransformer::class)]
final class CapabilityConfigurationValueTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityConfigurationValueTransformerInterface::KEY_KEY => 'test-key',
            CapabilityConfigurationValueTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            CapabilityConfigurationValueTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2'],
            CapabilityConfigurationValueTransformerInterface::KEY_STEP => 1.5,
        ];

        $transformer = new CapabilityConfigurationValueTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame(['test-enabled-values-1', 'test-enabled-values-2'], $actual->getEnabledValues());
        self::assertSame(1.5, $actual->getStep());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityConfigurationValueTransformer();

        $actual = $transformer->transform([CapabilityConfigurationValueTransformerInterface::KEY_KEY => 'test-key'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[CapabilityConfigurationValueTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[CapabilityConfigurationValueTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'enabledValuesAbsent' => [[], 'getEnabledValues', null];
        yield 'enabledValuesWrongType' => [[CapabilityConfigurationValueTransformerInterface::KEY_ENABLED_VALUES => 'not-array'], 'getEnabledValues', null];
        yield 'enabledValuesValid' => [[CapabilityConfigurationValueTransformerInterface::KEY_ENABLED_VALUES => ['test-enabled-values-1', 'test-enabled-values-2']], 'getEnabledValues', ['test-enabled-values-1', 'test-enabled-values-2']];
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[CapabilityConfigurationValueTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[CapabilityConfigurationValueTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new CapabilityConfigurationValueTransformer();

        $actual = $transformer->transform([CapabilityConfigurationValueTransformerInterface::KEY_KEY => 'test-key']);

        self::assertNull($actual->getRange());
        self::assertNull($actual->getEnabledValues());
        self::assertNull($actual->getStep());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CapabilityConfigurationValueTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'keyAbsent' => [[], sprintf(CapabilityConfigurationValueTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityConfigurationValueTransformerInterface::KEY_KEY)];
        yield 'keyWrongType' => [[CapabilityConfigurationValueTransformerInterface::KEY_KEY => 42], sprintf(CapabilityConfigurationValueTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityConfigurationValueTransformerInterface::KEY_KEY)];
    }
}
