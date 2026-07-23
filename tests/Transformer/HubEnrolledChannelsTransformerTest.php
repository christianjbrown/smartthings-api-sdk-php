<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubEnrolledChannelsTransformer::class)]
final class HubEnrolledChannelsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-channel-1'], ['test-channel-2']];

        $first = self::createStub(HubEnrolledChannelInterface::class);
        $second = self::createStub(HubEnrolledChannelInterface::class);

        $channelTransformer = self::createMock(HubEnrolledChannelTransformerInterface::class);
        $channelTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new HubEnrolledChannelsTransformer($channelTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $channelTransformer = self::createMock(HubEnrolledChannelTransformerInterface::class);
        $channelTransformer->expects(self::never())
            ->method('transform');

        $transformer = new HubEnrolledChannelsTransformer($channelTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $channelTransformer = self::createStub(HubEnrolledChannelTransformerInterface::class);

        $transformer = new HubEnrolledChannelsTransformer($channelTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HubEnrolledChannelsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubEnrolledChannelsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
