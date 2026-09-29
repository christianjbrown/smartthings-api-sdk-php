<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceRestriction;
use ChristianBrown\SmartThings\Transformer\DeviceRestrictionTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRestrictionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceRestriction::class)]
#[CoversClass(DeviceRestrictionTransformer::class)]
final class DeviceRestrictionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceRestrictionTransformerInterface::KEY_TIER => 7,
            DeviceRestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 7,
            DeviceRestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => true,
        ];

        $transformer = new DeviceRestrictionTransformer();

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
        $transformer = new DeviceRestrictionTransformer();

        $actual = $transformer->transform([DeviceRestrictionTransformerInterface::KEY_TIER => 7] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'historyRetentionTTLDaysAbsent' => [[], 'getHistoryRetentionTTLDays', null];
        yield 'historyRetentionTTLDaysWrongType' => [[DeviceRestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 'not-int'], 'getHistoryRetentionTTLDays', null];
        yield 'historyRetentionTTLDaysValid' => [[DeviceRestrictionTransformerInterface::KEY_HISTORY_RETENTION_TTLDAYS => 7], 'getHistoryRetentionTTLDays', 7];
        yield 'visibleWhenRestrictedAbsent' => [[], 'getVisibleWhenRestricted', null];
        yield 'visibleWhenRestrictedWrongType' => [[DeviceRestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => 'not-bool'], 'getVisibleWhenRestricted', null];
        yield 'visibleWhenRestrictedValid' => [[DeviceRestrictionTransformerInterface::KEY_VISIBLE_WHEN_RESTRICTED => true], 'getVisibleWhenRestricted', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceRestrictionTransformer();

        $actual = $transformer->transform([DeviceRestrictionTransformerInterface::KEY_TIER => 7]);

        self::assertNull($actual->getHistoryRetentionTTLDays());
        self::assertNull($actual->getVisibleWhenRestricted());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceRestrictionTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'tierAbsent' => [[], sprintf(DeviceRestrictionTransformerInterface::UNEXPECTED_INT_SPRINTF, DeviceRestrictionTransformerInterface::KEY_TIER)];
        yield 'tierWrongType' => [[DeviceRestrictionTransformerInterface::KEY_TIER => 'not-int'], sprintf(DeviceRestrictionTransformerInterface::UNEXPECTED_INT_SPRINTF, DeviceRestrictionTransformerInterface::KEY_TIER)];
    }
}
