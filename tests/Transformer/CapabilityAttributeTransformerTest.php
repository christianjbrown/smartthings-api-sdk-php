<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeSchemaInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttribute;
use ChristianBrown\SmartThings\Model\EnumCommandInterface;
use ChristianBrown\SmartThings\Transformer\AttributeSchemaTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityAttribute::class)]
#[CoversClass(CapabilityAttributeTransformer::class)]
final class CapabilityAttributeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $attributeSchemaModel = self::createStub(AttributeSchemaInterface::class);
        $attributeSchemaTransformer = self::createStub(AttributeSchemaTransformerInterface::class);
        $attributeSchemaTransformer->method('transform')->willReturn($attributeSchemaModel);
        $enumCommandModel = self::createStub(EnumCommandInterface::class);
        $enumCommandTransformer = self::createStub(EnumCommandTransformerInterface::class);
        $enumCommandTransformer->method('transform')->willReturn($enumCommandModel);
        $data = [
            CapabilityAttributeTransformerInterface::KEY_SCHEMA => ['test-nested'],
            CapabilityAttributeTransformerInterface::KEY_SETTER => 'test-setter',
            CapabilityAttributeTransformerInterface::KEY_ENUM_COMMANDS => [['test-nested']],
        ];

        $transformer = new CapabilityAttributeTransformer($attributeSchemaTransformer, $enumCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($attributeSchemaModel, $actual->getSchema());
        self::assertSame('test-setter', $actual->getSetter());
        self::assertSame([$enumCommandModel], $actual->getEnumCommands());
    }

    public function testTransformEnumCommands(): void
    {
        $attributeSchemaModel = self::createStub(AttributeSchemaInterface::class);
        $attributeSchemaTransformer = self::createStub(AttributeSchemaTransformerInterface::class);
        $attributeSchemaTransformer->method('transform')->willReturn($attributeSchemaModel);
        $enumCommandModel = self::createStub(EnumCommandInterface::class);
        $enumCommandTransformer = self::createStub(EnumCommandTransformerInterface::class);
        $enumCommandTransformer->method('transform')->willReturn($enumCommandModel);
        $transformer = new CapabilityAttributeTransformer($attributeSchemaTransformer, $enumCommandTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getEnumCommands());
        self::assertNull($transformer->transform($base + [CapabilityAttributeTransformerInterface::KEY_ENUM_COMMANDS => 'test-not-array'])->getEnumCommands());
        self::assertSame([$enumCommandModel], $transformer->transform($base + [CapabilityAttributeTransformerInterface::KEY_ENUM_COMMANDS => [['test-nested'], 'test-skipped']])->getEnumCommands());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityAttributeTransformer(self::createStub(AttributeSchemaTransformerInterface::class), self::createStub(EnumCommandTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'setterAbsent' => [[], 'getSetter', null];
        yield 'setterWrongType' => [[CapabilityAttributeTransformerInterface::KEY_SETTER => 42], 'getSetter', null];
        yield 'setterValid' => [[CapabilityAttributeTransformerInterface::KEY_SETTER => 'test-setter'], 'getSetter', 'test-setter'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $attributeSchemaModel = self::createStub(AttributeSchemaInterface::class);
        $attributeSchemaTransformer = self::createStub(AttributeSchemaTransformerInterface::class);
        $attributeSchemaTransformer->method('transform')->willReturn($attributeSchemaModel);
        $enumCommandModel = self::createStub(EnumCommandInterface::class);
        $enumCommandTransformer = self::createStub(EnumCommandTransformerInterface::class);
        $enumCommandTransformer->method('transform')->willReturn($enumCommandModel);
        $transformer = new CapabilityAttributeTransformer($attributeSchemaTransformer, $enumCommandTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getSchema());
        self::assertNull($actual->getSetter());
        self::assertNull($actual->getEnumCommands());
    }

    public function testTransformSchema(): void
    {
        $attributeSchemaModel = self::createStub(AttributeSchemaInterface::class);
        $attributeSchemaTransformer = self::createStub(AttributeSchemaTransformerInterface::class);
        $attributeSchemaTransformer->method('transform')->willReturn($attributeSchemaModel);
        $enumCommandModel = self::createStub(EnumCommandInterface::class);
        $enumCommandTransformer = self::createStub(EnumCommandTransformerInterface::class);
        $enumCommandTransformer->method('transform')->willReturn($enumCommandModel);
        $transformer = new CapabilityAttributeTransformer($attributeSchemaTransformer, $enumCommandTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getSchema());
        self::assertNull($transformer->transform($base + [CapabilityAttributeTransformerInterface::KEY_SCHEMA => 'test-not-array'])->getSchema());
        self::assertSame($attributeSchemaModel, $transformer->transform($base + [CapabilityAttributeTransformerInterface::KEY_SCHEMA => ['test-nested']])->getSchema());
    }
}
