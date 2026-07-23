<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ChannelDriversTransformer::class)]
final class ChannelDriversTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-channel-driver-1'], ['test-channel-driver-2']];

        $first = self::createStub(ChannelDriverInterface::class);
        $second = self::createStub(ChannelDriverInterface::class);

        $channelDriverTransformer = self::createMock(ChannelDriverTransformerInterface::class);
        $channelDriverTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new ChannelDriversTransformer($channelDriverTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $channelDriverTransformer = self::createMock(ChannelDriverTransformerInterface::class);
        $channelDriverTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ChannelDriversTransformer($channelDriverTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $channelDriverTransformer = self::createStub(ChannelDriverTransformerInterface::class);

        $transformer = new ChannelDriversTransformer($channelDriverTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelDriversTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ChannelDriversTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
