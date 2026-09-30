<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeDataSchema;
use ChristianBrown\SmartThings\Transformer\AttributeDataSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeDataSchemaTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeDataSchema::class)]
#[CoversClass(AttributeDataSchemaTransformer::class)]
final class AttributeDataSchemaTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AttributeDataSchemaTransformerInterface::KEY_TYPE => 'test-type',
            AttributeDataSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => true,
            AttributeDataSchemaTransformerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
            AttributeDataSchemaTransformerInterface::KEY_PROPERTIES => ['test-properties-key' => 'test-value'],
        ];

        $transformer = new AttributeDataSchemaTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-type', $actual->getType());
        self::assertTrue($actual->getAdditionalProperties());
        self::assertSame(['test-required-1', 'test-required-2'], $actual->getRequired());
        self::assertSame(['test-properties-key' => 'test-value'], $actual->getProperties());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new AttributeDataSchemaTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[AttributeDataSchemaTransformerInterface::KEY_TYPE => 42], 'getType', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeDataSchemaTransformer();

        $actual = $transformer->transform([AttributeDataSchemaTransformerInterface::KEY_TYPE => 'test-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'additionalPropertiesAbsent' => [[], 'getAdditionalProperties', null];
        yield 'additionalPropertiesWrongType' => [[AttributeDataSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => 'not-bool'], 'getAdditionalProperties', null];
        yield 'additionalPropertiesValid' => [[AttributeDataSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => true], 'getAdditionalProperties', true];
        yield 'requiredAbsent' => [[], 'getRequired', null];
        yield 'requiredWrongType' => [[AttributeDataSchemaTransformerInterface::KEY_REQUIRED => 'not-array'], 'getRequired', null];
        yield 'requiredValid' => [[AttributeDataSchemaTransformerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2']], 'getRequired', ['test-required-1', 'test-required-2']];
        yield 'propertiesAbsent' => [[], 'getProperties', null];
        yield 'propertiesWrongType' => [[AttributeDataSchemaTransformerInterface::KEY_PROPERTIES => 'not-array'], 'getProperties', null];
        yield 'propertiesValid' => [[AttributeDataSchemaTransformerInterface::KEY_PROPERTIES => ['test-properties-key' => 'test-value']], 'getProperties', ['test-properties-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AttributeDataSchemaTransformer();

        $actual = $transformer->transform([AttributeDataSchemaTransformerInterface::KEY_TYPE => 'test-type']);

        self::assertNull($actual->getAdditionalProperties());
        self::assertNull($actual->getRequired());
        self::assertNull($actual->getProperties());
    }
}
