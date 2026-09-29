<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ChannelDriver;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChannelDriver::class)]
#[CoversClass(ChannelDriverTransformer::class)]
final class ChannelDriverTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ChannelDriverTransformer();

        $actual = $transformer->transform([ChannelDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'createdDateAbsent' => [[], 'getCreatedDate', null];
        yield 'createdDateWrongType' => [[ChannelDriverTransformerInterface::KEY_CREATED_DATE => 42], 'getCreatedDate', null];
        yield 'createdDateValid' => [[ChannelDriverTransformerInterface::KEY_CREATED_DATE => 'test-created-date'], 'getCreatedDate', 'test-created-date'];
        yield 'lastModifiedDateAbsent' => [[], 'getLastModifiedDate', null];
        yield 'lastModifiedDateWrongType' => [[ChannelDriverTransformerInterface::KEY_LAST_MODIFIED_DATE => 42], 'getLastModifiedDate', null];
        yield 'lastModifiedDateValid' => [[ChannelDriverTransformerInterface::KEY_LAST_MODIFIED_DATE => 'test-last-modified-date'], 'getLastModifiedDate', 'test-last-modified-date'];
    }
}
