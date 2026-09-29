<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PatchItem;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformer;
use ChristianBrown\SmartThings\Transformer\PatchItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PatchItem::class)]
#[CoversClass(PatchItemTransformer::class)]
final class PatchItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PatchItemTransformerInterface::KEY_OP => 'test-op',
            PatchItemTransformerInterface::KEY_PATH => 'test-path',
            PatchItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
        ];

        $transformer = new PatchItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-op', $actual->getOp());
        self::assertSame('test-path', $actual->getPath());
        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PatchItemTransformer();

        $actual = $transformer->transform([PatchItemTransformerInterface::KEY_OP => 'test-op', PatchItemTransformerInterface::KEY_PATH => 'test-path'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[PatchItemTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[PatchItemTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PatchItemTransformer();

        $actual = $transformer->transform([PatchItemTransformerInterface::KEY_OP => 'test-op', PatchItemTransformerInterface::KEY_PATH => 'test-path']);

        self::assertNull($actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PatchItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'opAbsent' => [[PatchItemTransformerInterface::KEY_PATH => 'test-path'], sprintf(PatchItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PatchItemTransformerInterface::KEY_OP)];
        yield 'opWrongType' => [[PatchItemTransformerInterface::KEY_PATH => 'test-path', PatchItemTransformerInterface::KEY_OP => 42], sprintf(PatchItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PatchItemTransformerInterface::KEY_OP)];
        yield 'pathAbsent' => [[PatchItemTransformerInterface::KEY_OP => 'test-op'], sprintf(PatchItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PatchItemTransformerInterface::KEY_PATH)];
        yield 'pathWrongType' => [[PatchItemTransformerInterface::KEY_OP => 'test-op', PatchItemTransformerInterface::KEY_PATH => 42], sprintf(PatchItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, PatchItemTransformerInterface::KEY_PATH)];
    }
}
