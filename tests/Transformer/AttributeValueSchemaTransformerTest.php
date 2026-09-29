<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeValueSchema;
use ChristianBrown\SmartThings\Transformer\AttributeValueSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeValueSchemaTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeValueSchema::class)]
#[CoversClass(AttributeValueSchemaTransformer::class)]
final class AttributeValueSchemaTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AttributeValueSchemaTransformerInterface::KEY_TYPE => 'test-type',
            AttributeValueSchemaTransformerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
            AttributeValueSchemaTransformerInterface::KEY_ADDITIONAL_KEYWORDS => ['test-additional-keywords-key' => 'test-value'],
        ];

        $transformer = new AttributeValueSchemaTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-type', $actual->getType());
        self::assertSame(['test-enum-1', 'test-enum-2'], $actual->getEnum());
        self::assertSame(['test-additional-keywords-key' => 'test-value'], $actual->getAdditionalKeywords());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeValueSchemaTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[AttributeValueSchemaTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[AttributeValueSchemaTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'enumAbsent' => [[], 'getEnum', null];
        yield 'enumWrongType' => [[AttributeValueSchemaTransformerInterface::KEY_ENUM => 'not-array'], 'getEnum', null];
        yield 'enumValid' => [[AttributeValueSchemaTransformerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2']], 'getEnum', ['test-enum-1', 'test-enum-2']];
        yield 'additionalKeywordsAbsent' => [[], 'getAdditionalKeywords', null];
        yield 'additionalKeywordsWrongType' => [[AttributeValueSchemaTransformerInterface::KEY_ADDITIONAL_KEYWORDS => 'not-array'], 'getAdditionalKeywords', null];
        yield 'additionalKeywordsValid' => [[AttributeValueSchemaTransformerInterface::KEY_ADDITIONAL_KEYWORDS => ['test-additional-keywords-key' => 'test-value']], 'getAdditionalKeywords', ['test-additional-keywords-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AttributeValueSchemaTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getType());
        self::assertNull($actual->getEnum());
        self::assertNull($actual->getAdditionalKeywords());
    }
}
