<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Restriction;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformer;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Restriction::class)]
#[CoversClass(RestrictionTransformer::class)]
final class RestrictionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RestrictionTransformerInterface::KEY_TIER => 7,
            RestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 7,
            RestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => true,
        ];

        $transformer = new RestrictionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getTier());
        self::assertSame(7, $actual->getHistoryRetentionTTLDays());
        self::assertTrue($actual->getVisibleWhenRestricted());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new RestrictionTransformer();

        $actual = $transformer->transform([RestrictionTransformerInterface::KEY_TIER => 7] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'historyRetentionTTLDaysAbsent' => [[], 'getHistoryRetentionTTLDays', null];
        yield 'historyRetentionTTLDaysWrongType' => [[RestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 'not-int'], 'getHistoryRetentionTTLDays', null];
        yield 'historyRetentionTTLDaysValid' => [[RestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 7], 'getHistoryRetentionTTLDays', 7];
        yield 'visibleWhenRestrictedAbsent' => [[], 'getVisibleWhenRestricted', null];
        yield 'visibleWhenRestrictedWrongType' => [[RestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => 'not-bool'], 'getVisibleWhenRestricted', null];
        yield 'visibleWhenRestrictedValid' => [[RestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => true], 'getVisibleWhenRestricted', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new RestrictionTransformer();

        $actual = $transformer->transform([RestrictionTransformerInterface::KEY_TIER => 7]);

        self::assertNull($actual->getHistoryRetentionTTLDays());
        self::assertNull($actual->getVisibleWhenRestricted());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new RestrictionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'tierAbsent' => [[], sprintf(RestrictionTransformerInterface::UNEXPECTED_INT_SPRINTF, RestrictionTransformerInterface::KEY_TIER)];
        yield 'tierWrongType' => [[RestrictionTransformerInterface::KEY_TIER => 'not-int'], sprintf(RestrictionTransformerInterface::UNEXPECTED_INT_SPRINTF, RestrictionTransformerInterface::KEY_TIER)];
    }
}
