<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeUnitSchema;
use ChristianBrown\SmartThings\Transformer\AttributeUnitSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeUnitSchemaTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeUnitSchema::class)]
#[CoversClass(AttributeUnitSchemaTransformer::class)]
final class AttributeUnitSchemaTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AttributeUnitSchemaTransformerInterface::KEY_TYPE => 'test-type',
            AttributeUnitSchemaTransformerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2'],
            AttributeUnitSchemaTransformerInterface::KEY_DEFAULT => 'test-default',
        ];

        $transformer = new AttributeUnitSchemaTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-type', $actual->getType());
        self::assertSame(['test-enum-1', 'test-enum-2'], $actual->getEnum());
        self::assertSame('test-default', $actual->getDefault());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeUnitSchemaTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[AttributeUnitSchemaTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[AttributeUnitSchemaTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'enumAbsent' => [[], 'getEnum', null];
        yield 'enumWrongType' => [[AttributeUnitSchemaTransformerInterface::KEY_ENUM => 'not-array'], 'getEnum', null];
        yield 'enumValid' => [[AttributeUnitSchemaTransformerInterface::KEY_ENUM => ['test-enum-1', 'test-enum-2']], 'getEnum', ['test-enum-1', 'test-enum-2']];
        yield 'defaultAbsent' => [[], 'getDefault', null];
        yield 'defaultWrongType' => [[AttributeUnitSchemaTransformerInterface::KEY_DEFAULT => 42], 'getDefault', null];
        yield 'defaultValid' => [[AttributeUnitSchemaTransformerInterface::KEY_DEFAULT => 'test-default'], 'getDefault', 'test-default'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AttributeUnitSchemaTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getType());
        self::assertNull($actual->getEnum());
        self::assertNull($actual->getDefault());
    }
}
