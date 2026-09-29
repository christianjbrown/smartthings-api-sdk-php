<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Clusters;
use ChristianBrown\SmartThings\Transformer\ClustersTransformer;
use ChristianBrown\SmartThings\Transformer\ClustersTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Clusters::class)]
#[CoversClass(ClustersTransformer::class)]
final class ClustersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ClustersTransformerInterface::KEY_CLIENT => [1, 2],
            ClustersTransformerInterface::KEY_SERVER => [1, 2],
        ];

        $transformer = new ClustersTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([1, 2], $actual->getClient());
        self::assertSame([1, 2], $actual->getServer());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ClustersTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'clientAbsent' => [[], 'getClient', null];
        yield 'clientWrongType' => [[ClustersTransformerInterface::KEY_CLIENT => 'not-array'], 'getClient', null];
        yield 'clientValid' => [[ClustersTransformerInterface::KEY_CLIENT => [1, 2]], 'getClient', [1, 2]];
        yield 'serverAbsent' => [[], 'getServer', null];
        yield 'serverWrongType' => [[ClustersTransformerInterface::KEY_SERVER => 'not-array'], 'getServer', null];
        yield 'serverValid' => [[ClustersTransformerInterface::KEY_SERVER => [1, 2]], 'getServer', [1, 2]];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ClustersTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getClient());
        self::assertNull($actual->getServer());
    }
}
