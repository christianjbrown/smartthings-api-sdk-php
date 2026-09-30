<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedConditionItemIdExcludeItem::class)]
#[CoversClass(ExcludedConditionItemIdExcludeItemTransformer::class)]
final class ExcludedConditionItemIdExcludeItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $data = [
            ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 'test-component',
            ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_VERSION => 7,
            ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_ATTRIBUTES => [['test-nested']],
        ];

        $transformer = new ExcludedConditionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame([$excludedConditionItemIdExcludeItemAttributesItemModel], $actual->getAttributes());
    }

    public function testTransformAttributes(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $transformer = new ExcludedConditionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);
        $base = [ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getAttributes());
        self::assertNull($transformer->transform($base + [ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_ATTRIBUTES => 'test-not-array'])->getAttributes());
        self::assertSame([$excludedConditionItemIdExcludeItemAttributesItemModel], $transformer->transform($base + [ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_ATTRIBUTES => [['test-nested'], 'test-skipped']])->getAttributes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemIdExcludeItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[], 'getCapability', null];
        yield 'capabilityWrongType' => [[ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedConditionItemIdExcludeItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $transformer = new ExcludedConditionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);

        $actual = $transformer->transform([ExcludedConditionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getAttributes());
    }
}
