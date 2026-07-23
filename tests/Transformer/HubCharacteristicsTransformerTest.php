<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubCharacteristicsTransformer::class)]
final class HubCharacteristicsTransformerTest extends TestCase
{
    /**
     * Exercises the loop across each combination: empty (not entered), a single
     * scalar (kept), a single non-scalar (skipped), and mixed orderings.
     *
     * @param mixed[]                              $data
     * @param array<string, bool|float|int|string> $expected
     */
    #[DataProvider('provideTransformCases')]
    public function testTransform(array $data, array $expected): void
    {
        $transformer = new HubCharacteristicsTransformer();

        self::assertSame($expected, $transformer->transform($data));
    }

    /**
     * @return iterable<string, array{mixed[], array<string, bool|float|int|string>}>
     */
    public static function provideTransformCases(): iterable
    {
        yield 'empty' => [[], []];
        yield 'singleScalar' => [['zigbeeChannel' => 20], ['zigbeeChannel' => 20]];
        yield 'singleNonScalar' => [['nested' => ['ignored']], []];
        yield 'allScalarTypes' => [
            ['zigbeeChannel' => 20, 'model' => 'Hub v3', 'signalMetrics' => 1.5, 'zwaveEnabled' => true],
            ['zigbeeChannel' => 20, 'model' => 'Hub v3', 'signalMetrics' => 1.5, 'zwaveEnabled' => true],
        ];
        yield 'scalarThenNonScalar' => [['model' => 'Hub v3', 'nested' => ['ignored']], ['model' => 'Hub v3']];
        yield 'nonScalarThenScalar' => [['nested' => ['ignored'], 'model' => 'Hub v3'], ['model' => 'Hub v3']];
    }
}
