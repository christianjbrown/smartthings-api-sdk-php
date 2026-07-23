<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceLocationInfoSubscriptionsTransformer::class)]
final class ServiceLocationInfoSubscriptionsTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [['test-subscription-1'], ['test-subscription-2']];

        $first = self::createStub(ServiceLocationInfoSubscriptionInterface::class);
        $second = self::createStub(ServiceLocationInfoSubscriptionInterface::class);

        $subscriptionTransformer = self::createMock(ServiceLocationInfoSubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::exactly(2))
            ->method('transform')
            ->willReturn($first, $second);

        $transformer = new ServiceLocationInfoSubscriptionsTransformer($subscriptionTransformer);

        self::assertSame([$first, $second], $transformer->transform($data));
    }

    /**
     * @throws Exception
     */
    public function testTransformEmpty(): void
    {
        $subscriptionTransformer = self::createMock(ServiceLocationInfoSubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ServiceLocationInfoSubscriptionsTransformer($subscriptionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    /**
     * @throws Exception
     */
    public function testTransformUnexpectedEntry(): void
    {
        $subscriptionTransformer = self::createStub(ServiceLocationInfoSubscriptionTransformerInterface::class);

        $transformer = new ServiceLocationInfoSubscriptionsTransformer($subscriptionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceLocationInfoSubscriptionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ServiceLocationInfoSubscriptionsTransformerInterface::ARRAY_NAME));
        $transformer->transform(['test-not-an-array']);
    }
}
