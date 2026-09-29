<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributePropertiesInterface;
use ChristianBrown\SmartThings\Model\AttributeSchema;
use ChristianBrown\SmartThings\Transformer\AttributePropertiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AttributeSchemaTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeSchemaTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AttributeSchema::class)]
#[CoversClass(AttributeSchemaTransformer::class)]
final class AttributeSchemaTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $attributePropertiesModel = self::createStub(AttributePropertiesInterface::class);
        $attributePropertiesTransformer = self::createStub(AttributePropertiesTransformerInterface::class);
        $attributePropertiesTransformer->method('transform')->willReturn($attributePropertiesModel);
        $data = [
            AttributeSchemaTransformerInterface::KEY_TITLE => 'test-title',
            AttributeSchemaTransformerInterface::KEY_TYPE => 'test-type',
            AttributeSchemaTransformerInterface::KEY_PROPERTIES => ['test-nested'],
            AttributeSchemaTransformerInterface::KEY_SENSITIVE => true,
            AttributeSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => true,
            AttributeSchemaTransformerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2'],
        ];

        $transformer = new AttributeSchemaTransformer($attributePropertiesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-title', $actual->getTitle());
        self::assertSame('test-type', $actual->getType());
        self::assertSame($attributePropertiesModel, $actual->getProperties());
        self::assertTrue($actual->getSensitive());
        self::assertTrue($actual->getAdditionalProperties());
        self::assertSame(['test-required-1', 'test-required-2'], $actual->getRequired());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeSchemaTransformer(self::createStub(AttributePropertiesTransformerInterface::class));

        $actual = $transformer->transform([AttributeSchemaTransformerInterface::KEY_PROPERTIES => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'titleAbsent' => [[], 'getTitle', null];
        yield 'titleWrongType' => [[AttributeSchemaTransformerInterface::KEY_TITLE => 42], 'getTitle', null];
        yield 'titleValid' => [[AttributeSchemaTransformerInterface::KEY_TITLE => 'test-title'], 'getTitle', 'test-title'];
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[AttributeSchemaTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[AttributeSchemaTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'sensitiveAbsent' => [[], 'getSensitive', null];
        yield 'sensitiveWrongType' => [[AttributeSchemaTransformerInterface::KEY_SENSITIVE => 'not-bool'], 'getSensitive', null];
        yield 'sensitiveValid' => [[AttributeSchemaTransformerInterface::KEY_SENSITIVE => true], 'getSensitive', true];
        yield 'additionalPropertiesAbsent' => [[], 'getAdditionalProperties', null];
        yield 'additionalPropertiesWrongType' => [[AttributeSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => 'not-bool'], 'getAdditionalProperties', null];
        yield 'additionalPropertiesValid' => [[AttributeSchemaTransformerInterface::KEY_ADDITIONAL_PROPERTIES => true], 'getAdditionalProperties', true];
        yield 'requiredAbsent' => [[], 'getRequired', null];
        yield 'requiredWrongType' => [[AttributeSchemaTransformerInterface::KEY_REQUIRED => 'not-array'], 'getRequired', null];
        yield 'requiredValid' => [[AttributeSchemaTransformerInterface::KEY_REQUIRED => ['test-required-1', 'test-required-2']], 'getRequired', ['test-required-1', 'test-required-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $attributePropertiesModel = self::createStub(AttributePropertiesInterface::class);
        $attributePropertiesTransformer = self::createStub(AttributePropertiesTransformerInterface::class);
        $attributePropertiesTransformer->method('transform')->willReturn($attributePropertiesModel);
        $transformer = new AttributeSchemaTransformer($attributePropertiesTransformer);

        $actual = $transformer->transform([AttributeSchemaTransformerInterface::KEY_PROPERTIES => ['test-nested']]);

        self::assertNull($actual->getTitle());
        self::assertNull($actual->getType());
        self::assertNull($actual->getSensitive());
        self::assertNull($actual->getAdditionalProperties());
        self::assertNull($actual->getRequired());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new AttributeSchemaTransformer(self::createStub(AttributePropertiesTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'propertiesAbsent' => [[], sprintf(AttributeSchemaTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AttributeSchemaTransformerInterface::KEY_PROPERTIES)];
        yield 'propertiesWrongType' => [[AttributeSchemaTransformerInterface::KEY_PROPERTIES => 'not-array'], sprintf(AttributeSchemaTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AttributeSchemaTransformerInterface::KEY_PROPERTIES)];
    }
}
