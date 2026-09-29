<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributeDataSchemaInterface;
use ChristianBrown\SmartThings\Model\AttributeProperties;
use ChristianBrown\SmartThings\Model\AttributeUnitSchemaInterface;
use ChristianBrown\SmartThings\Model\AttributeValueSchemaInterface;
use ChristianBrown\SmartThings\Transformer\AttributeDataSchemaTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AttributePropertiesTransformer;
use ChristianBrown\SmartThings\Transformer\AttributePropertiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AttributeUnitSchemaTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AttributeValueSchemaTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(AttributeProperties::class)]
#[CoversClass(AttributePropertiesTransformer::class)]
final class AttributePropertiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $attributeValueSchemaModel = self::createStub(AttributeValueSchemaInterface::class);
        $attributeValueSchemaTransformer = self::createStub(AttributeValueSchemaTransformerInterface::class);
        $attributeValueSchemaTransformer->method('transform')->willReturn($attributeValueSchemaModel);
        $attributeUnitSchemaModel = self::createStub(AttributeUnitSchemaInterface::class);
        $attributeUnitSchemaTransformer = self::createStub(AttributeUnitSchemaTransformerInterface::class);
        $attributeUnitSchemaTransformer->method('transform')->willReturn($attributeUnitSchemaModel);
        $attributeDataSchemaModel = self::createStub(AttributeDataSchemaInterface::class);
        $attributeDataSchemaTransformer = self::createStub(AttributeDataSchemaTransformerInterface::class);
        $attributeDataSchemaTransformer->method('transform')->willReturn($attributeDataSchemaModel);
        $data = [
            AttributePropertiesTransformerInterface::KEY_VALUE => ['test-nested'],
            AttributePropertiesTransformerInterface::KEY_UNIT => ['test-nested'],
            AttributePropertiesTransformerInterface::KEY_DATA => ['test-nested'],
        ];

        $transformer = new AttributePropertiesTransformer($attributeValueSchemaTransformer, $attributeUnitSchemaTransformer, $attributeDataSchemaTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($attributeValueSchemaModel, $actual->getValue());
        self::assertSame($attributeUnitSchemaModel, $actual->getUnit());
        self::assertSame($attributeDataSchemaModel, $actual->getData());
    }

    public function testTransformData(): void
    {
        $attributeValueSchemaModel = self::createStub(AttributeValueSchemaInterface::class);
        $attributeValueSchemaTransformer = self::createStub(AttributeValueSchemaTransformerInterface::class);
        $attributeValueSchemaTransformer->method('transform')->willReturn($attributeValueSchemaModel);
        $attributeUnitSchemaModel = self::createStub(AttributeUnitSchemaInterface::class);
        $attributeUnitSchemaTransformer = self::createStub(AttributeUnitSchemaTransformerInterface::class);
        $attributeUnitSchemaTransformer->method('transform')->willReturn($attributeUnitSchemaModel);
        $attributeDataSchemaModel = self::createStub(AttributeDataSchemaInterface::class);
        $attributeDataSchemaTransformer = self::createStub(AttributeDataSchemaTransformerInterface::class);
        $attributeDataSchemaTransformer->method('transform')->willReturn($attributeDataSchemaModel);
        $transformer = new AttributePropertiesTransformer($attributeValueSchemaTransformer, $attributeUnitSchemaTransformer, $attributeDataSchemaTransformer);
        $base = [AttributePropertiesTransformerInterface::KEY_VALUE => ['test-nested']];

        self::assertNull($transformer->transform($base)->getData());
        self::assertNull($transformer->transform($base + [AttributePropertiesTransformerInterface::KEY_DATA => 'test-not-array'])->getData());
        self::assertSame($attributeDataSchemaModel, $transformer->transform($base + [AttributePropertiesTransformerInterface::KEY_DATA => ['test-nested']])->getData());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $attributeValueSchemaModel = self::createStub(AttributeValueSchemaInterface::class);
        $attributeValueSchemaTransformer = self::createStub(AttributeValueSchemaTransformerInterface::class);
        $attributeValueSchemaTransformer->method('transform')->willReturn($attributeValueSchemaModel);
        $attributeUnitSchemaModel = self::createStub(AttributeUnitSchemaInterface::class);
        $attributeUnitSchemaTransformer = self::createStub(AttributeUnitSchemaTransformerInterface::class);
        $attributeUnitSchemaTransformer->method('transform')->willReturn($attributeUnitSchemaModel);
        $attributeDataSchemaModel = self::createStub(AttributeDataSchemaInterface::class);
        $attributeDataSchemaTransformer = self::createStub(AttributeDataSchemaTransformerInterface::class);
        $attributeDataSchemaTransformer->method('transform')->willReturn($attributeDataSchemaModel);
        $transformer = new AttributePropertiesTransformer($attributeValueSchemaTransformer, $attributeUnitSchemaTransformer, $attributeDataSchemaTransformer);

        $actual = $transformer->transform([AttributePropertiesTransformerInterface::KEY_VALUE => ['test-nested']]);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getData());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new AttributePropertiesTransformer(self::createStub(AttributeValueSchemaTransformerInterface::class), self::createStub(AttributeUnitSchemaTransformerInterface::class), self::createStub(AttributeDataSchemaTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[], sprintf(AttributePropertiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AttributePropertiesTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[AttributePropertiesTransformerInterface::KEY_VALUE => 'not-array'], sprintf(AttributePropertiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, AttributePropertiesTransformerInterface::KEY_VALUE)];
    }

    public function testTransformUnit(): void
    {
        $attributeValueSchemaModel = self::createStub(AttributeValueSchemaInterface::class);
        $attributeValueSchemaTransformer = self::createStub(AttributeValueSchemaTransformerInterface::class);
        $attributeValueSchemaTransformer->method('transform')->willReturn($attributeValueSchemaModel);
        $attributeUnitSchemaModel = self::createStub(AttributeUnitSchemaInterface::class);
        $attributeUnitSchemaTransformer = self::createStub(AttributeUnitSchemaTransformerInterface::class);
        $attributeUnitSchemaTransformer->method('transform')->willReturn($attributeUnitSchemaModel);
        $attributeDataSchemaModel = self::createStub(AttributeDataSchemaInterface::class);
        $attributeDataSchemaTransformer = self::createStub(AttributeDataSchemaTransformerInterface::class);
        $attributeDataSchemaTransformer->method('transform')->willReturn($attributeDataSchemaModel);
        $transformer = new AttributePropertiesTransformer($attributeValueSchemaTransformer, $attributeUnitSchemaTransformer, $attributeDataSchemaTransformer);
        $base = [AttributePropertiesTransformerInterface::KEY_VALUE => ['test-nested']];

        self::assertNull($transformer->transform($base)->getUnit());
        self::assertNull($transformer->transform($base + [AttributePropertiesTransformerInterface::KEY_UNIT => 'test-not-array'])->getUnit());
        self::assertSame($attributeUnitSchemaModel, $transformer->transform($base + [AttributePropertiesTransformerInterface::KEY_UNIT => ['test-nested']])->getUnit());
    }
}
