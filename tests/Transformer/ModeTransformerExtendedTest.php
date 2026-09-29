<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Mode;
use ChristianBrown\SmartThings\Transformer\ModeTransformer;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Mode::class)]
#[CoversClass(ModeTransformer::class)]
final class ModeTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ModeTransformer();

        $actual = $transformer->transform([ModeTransformerInterface::KEY_ID => 'test-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'allowedAbsent' => [[], 'getAllowed', []];
        yield 'allowedWrongType' => [[ModeTransformerInterface::KEY_ALLOWED => 'not-array'], 'getAllowed', []];
        yield 'allowedValid' => [[ModeTransformerInterface::KEY_ALLOWED => ['test-allowed-1', 42, 'test-allowed-2']], 'getAllowed', ['test-allowed-1', 'test-allowed-2']];
    }
}
