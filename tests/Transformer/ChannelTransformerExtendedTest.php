<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Channel;
use ChristianBrown\SmartThings\Transformer\ChannelTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Channel::class)]
#[CoversClass(ChannelTransformer::class)]
final class ChannelTransformerExtendedTest extends TestCase
{
    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ChannelTransformer();

        $actual = $transformer->transform([ChannelTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'createdDateAbsent' => [[], 'getCreatedDate', null];
        yield 'createdDateWrongType' => [[ChannelTransformerInterface::KEY_CREATED_DATE => 42], 'getCreatedDate', null];
        yield 'createdDateValid' => [[ChannelTransformerInterface::KEY_CREATED_DATE => 'test-created-date'], 'getCreatedDate', 'test-created-date'];
        yield 'lastModifiedDateAbsent' => [[], 'getLastModifiedDate', null];
        yield 'lastModifiedDateWrongType' => [[ChannelTransformerInterface::KEY_LAST_MODIFIED_DATE => 42], 'getLastModifiedDate', null];
        yield 'lastModifiedDateValid' => [[ChannelTransformerInterface::KEY_LAST_MODIFIED_DATE => 'test-last-modified-date'], 'getLastModifiedDate', 'test-last-modified-date'];
    }
}
