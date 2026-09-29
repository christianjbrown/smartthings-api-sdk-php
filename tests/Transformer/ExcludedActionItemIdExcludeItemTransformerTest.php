<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedActionItemIdExcludeItem::class)]
#[CoversClass(ExcludedActionItemIdExcludeItemTransformer::class)]
final class ExcludedActionItemIdExcludeItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $data = [
            ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 'test-component',
            ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            ExcludedActionItemIdExcludeItemTransformerInterface::KEY_VERSION => 7,
            ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMMANDS => [['test-nested']],
        ];

        $transformer = new ExcludedActionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame([$excludedConditionItemIdExcludeItemAttributesItemModel], $actual->getCommands());
    }

    public function testTransformCommands(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $transformer = new ExcludedActionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);
        $base = [ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability'];

        self::assertNull($transformer->transform($base)->getCommands());
        self::assertNull($transformer->transform($base + [ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMMANDS => 'test-not-array'])->getCommands());
        self::assertSame([$excludedConditionItemIdExcludeItemAttributesItemModel], $transformer->transform($base + [ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMMANDS => [['test-nested'], 'test-skipped']])->getCommands());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedActionItemIdExcludeItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'componentAbsent' => [[], 'getComponent', null];
        yield 'componentWrongType' => [[ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'componentValid' => [[ExcludedActionItemIdExcludeItemTransformerInterface::KEY_COMPONENT => 'test-component'], 'getComponent', 'test-component'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[ExcludedActionItemIdExcludeItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[ExcludedActionItemIdExcludeItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemTransformer->method('transform')->willReturn($excludedConditionItemIdExcludeItemAttributesItemModel);
        $transformer = new ExcludedActionItemIdExcludeItemTransformer($excludedConditionItemIdExcludeItemAttributesItemTransformer);

        $actual = $transformer->transform([ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 'test-capability']);

        self::assertNull($actual->getComponent());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getCommands());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ExcludedActionItemIdExcludeItemTransformer(self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[], sprintf(ExcludedActionItemIdExcludeItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(ExcludedActionItemIdExcludeItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ExcludedActionItemIdExcludeItemTransformerInterface::KEY_CAPABILITY)];
    }
}
