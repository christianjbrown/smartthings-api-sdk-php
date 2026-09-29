<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IdLessHealthState;
use ChristianBrown\SmartThings\Transformer\IdLessHealthStateTransformer;
use ChristianBrown\SmartThings\Transformer\IdLessHealthStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IdLessHealthState::class)]
#[CoversClass(IdLessHealthStateTransformer::class)]
final class IdLessHealthStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            IdLessHealthStateTransformerInterface::KEY_STATE => 'test-state',
            IdLessHealthStateTransformerInterface::KEY_LAST_UPDATED_DATE => 'test-last-updated-date',
        ];

        $transformer = new IdLessHealthStateTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-state', $actual->getState());
        self::assertSame('test-last-updated-date', $actual->getLastUpdatedDate());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new IdLessHealthStateTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'stateAbsent' => [[], 'getState', null];
        yield 'stateWrongType' => [[IdLessHealthStateTransformerInterface::KEY_STATE => 42], 'getState', null];
        yield 'stateValid' => [[IdLessHealthStateTransformerInterface::KEY_STATE => 'test-state'], 'getState', 'test-state'];
        yield 'lastUpdatedDateAbsent' => [[], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateWrongType' => [[IdLessHealthStateTransformerInterface::KEY_LAST_UPDATED_DATE => 42], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateValid' => [[IdLessHealthStateTransformerInterface::KEY_LAST_UPDATED_DATE => 'test-last-updated-date'], 'getLastUpdatedDate', 'test-last-updated-date'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new IdLessHealthStateTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getState());
        self::assertNull($actual->getLastUpdatedDate());
    }
}
