<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ModeSubscriptionDetail;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModeSubscriptionDetail::class)]
#[CoversClass(ModeSubscriptionDetailTransformer::class)]
final class ModeSubscriptionDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new ModeSubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ModeSubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'locationIdAbsent' => [[], 'getLocationId', null];
        yield 'locationIdWrongType' => [[ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 42], 'getLocationId', null];
    }
}
