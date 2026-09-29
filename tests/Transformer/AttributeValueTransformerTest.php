<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValue;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeValue::class)]
#[CoversClass(AttributeValueTransformer::class)]
final class AttributeValueTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AttributeValueTransformerInterface::KEY_ATTRIBUTE => 'test-attribute',
            AttributeValueTransformerInterface::KEY_INPUT_TYPE => 'test-input-type',
            AttributeValueTransformerInterface::KEY_STATIC_VALUE => ['test-static-value-key' => 'test-value'],
        ];

        $transformer = new AttributeValueTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-attribute', $actual->getAttribute());
        self::assertSame('test-input-type', $actual->getInputType());
        self::assertSame(['test-static-value-key' => 'test-value'], $actual->getStaticValue());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeValueTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'attributeAbsent' => [[], 'getAttribute', null];
        yield 'attributeWrongType' => [[AttributeValueTransformerInterface::KEY_ATTRIBUTE => 42], 'getAttribute', null];
        yield 'attributeValid' => [[AttributeValueTransformerInterface::KEY_ATTRIBUTE => 'test-attribute'], 'getAttribute', 'test-attribute'];
        yield 'inputTypeAbsent' => [[], 'getInputType', null];
        yield 'inputTypeWrongType' => [[AttributeValueTransformerInterface::KEY_INPUT_TYPE => 42], 'getInputType', null];
        yield 'inputTypeValid' => [[AttributeValueTransformerInterface::KEY_INPUT_TYPE => 'test-input-type'], 'getInputType', 'test-input-type'];
        yield 'staticValueAbsent' => [[], 'getStaticValue', null];
        yield 'staticValueWrongType' => [[AttributeValueTransformerInterface::KEY_STATIC_VALUE => 'not-array'], 'getStaticValue', null];
        yield 'staticValueValid' => [[AttributeValueTransformerInterface::KEY_STATIC_VALUE => ['test-static-value-key' => 'test-value']], 'getStaticValue', ['test-static-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AttributeValueTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getAttribute());
        self::assertNull($actual->getInputType());
        self::assertNull($actual->getStaticValue());
    }
}
