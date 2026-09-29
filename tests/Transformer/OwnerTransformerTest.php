<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Owner;
use ChristianBrown\SmartThings\Transformer\OwnerTransformer;
use ChristianBrown\SmartThings\Transformer\OwnerTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new OwnerTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'ownerTypeAbsent' => [[OwnerTransformerInterface::KEY_OWNER_ID => 'test-owner-id'], sprintf(OwnerTransformerInterface::UNEXPECTED_STRING_SPRINTF, OwnerTransformerInterface::KEY_OWNER_TYPE)];
        yield 'ownerTypeWrongType' => [[OwnerTransformerInterface::KEY_OWNER_ID => 'test-owner-id', OwnerTransformerInterface::KEY_OWNER_TYPE => 42], sprintf(OwnerTransformerInterface::UNEXPECTED_STRING_SPRINTF, OwnerTransformerInterface::KEY_OWNER_TYPE)];
        yield 'ownerIdAbsent' => [[OwnerTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type'], sprintf(OwnerTransformerInterface::UNEXPECTED_STRING_SPRINTF, OwnerTransformerInterface::KEY_OWNER_ID)];
        yield 'ownerIdWrongType' => [[OwnerTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type', OwnerTransformerInterface::KEY_OWNER_ID => 42], sprintf(OwnerTransformerInterface::UNEXPECTED_STRING_SPRINTF, OwnerTransformerInterface::KEY_OWNER_ID)];
    }
}
