<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Owner;
use ChristianBrown\SmartThings\Transformer\OwnerTransformer;
use ChristianBrown\SmartThings\Transformer\OwnerTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Owner::class)]
#[CoversClass(OwnerTransformer::class)]
final class OwnerTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            OwnerTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type',
            OwnerTransformerInterface::KEY_OWNER_ID => 'test-owner-id',
        ];

        $transformer = new OwnerTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-owner-type', $actual->getOwnerType());
        self::assertSame('test-owner-id', $actual->getOwnerId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new OwnerTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'ownerTypeAbsent' => [[OwnerTransformerInterface::KEY_OWNER_ID => 'test-owner-id'], 'getOwnerType', null];
        yield 'ownerTypeWrongType' => [[OwnerTransformerInterface::KEY_OWNER_ID => 'test-owner-id', OwnerTransformerInterface::KEY_OWNER_TYPE => 42], 'getOwnerType', null];
        yield 'ownerIdAbsent' => [[OwnerTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type'], 'getOwnerId', null];
        yield 'ownerIdWrongType' => [[OwnerTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type', OwnerTransformerInterface::KEY_OWNER_ID => 42], 'getOwnerId', null];
    }
}
