<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelInterface;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ChannelsTransformer::class)]
final class ChannelsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-channel-1'], ['test-channel-2']];

        $first = self::createStub(ChannelInterface::class);
        $second = self::createStub(ChannelInterface::class);

        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new ChannelsTransformer($channelTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ChannelsTransformer($channelTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $channelTransformer = self::createStub(ChannelTransformerInterface::class);

        $transformer = new ChannelsTransformer($channelTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ChannelsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
