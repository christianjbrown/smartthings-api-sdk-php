<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedActionItem;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemIdExcludeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemTransformer;
use ChristianBrown\SmartThings\Transformer\ExcludedActionItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ExcludedActionItem::class)]
#[CoversClass(ExcludedActionItemTransformer::class)]
final class ExcludedActionItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemTransformer = self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class);
        $excludedActionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedActionItemIdExcludeItemModel);
        $data = [
            ExcludedActionItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            ExcludedActionItemTransformerInterface::KEY_EXCLUDE => [['test-nested']],
        ];

        $transformer = new ExcludedActionItemTransformer($excludedActionItemIdExcludeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertSame([$excludedActionItemIdExcludeItemModel], $actual->getExclude());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ExcludedActionItemTransformer(self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class));

        $actual = $transformer->transform([ExcludedActionItemTransformerInterface::KEY_EXCLUDE => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ExcludedActionItemTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[ExcludedActionItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemTransformer = self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class);
        $excludedActionItemIdExcludeItemTransformer->method('transform')->willReturn($excludedActionItemIdExcludeItemModel);
        $transformer = new ExcludedActionItemTransformer($excludedActionItemIdExcludeItemTransformer);

        $actual = $transformer->transform([ExcludedActionItemTransformerInterface::KEY_EXCLUDE => ['test-nested']]);

        self::assertNull($actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ExcludedActionItemTransformer(self::createStub(ExcludedActionItemIdExcludeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'excludeAbsent' => [[], sprintf(ExcludedActionItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ExcludedActionItemTransformerInterface::KEY_EXCLUDE)];
        yield 'excludeWrongType' => [[ExcludedActionItemTransformerInterface::KEY_EXCLUDE => 'not-array'], sprintf(ExcludedActionItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ExcludedActionItemTransformerInterface::KEY_EXCLUDE)];
    }
}
