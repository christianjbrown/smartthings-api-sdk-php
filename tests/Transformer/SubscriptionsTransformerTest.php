<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SubscriptionInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformer;
use ChristianBrown\SmartThings\Transformer\SubscriptionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SubscriptionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SubscriptionsTransformer::class)]
final class SubscriptionsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-subscription-1'], ['test-subscription-2']];

        $subscription1 = self::createStub(SubscriptionInterface::class);
        $subscription2 = self::createStub(SubscriptionInterface::class);
        $subscriptions = [$subscription1, $subscription2];

        $subscriptionTransformer = self::createStub(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-subscription-1'], $subscription1],
                    [['test-subscription-2'], $subscription2],
                ]
            );

        $transformer = new SubscriptionsTransformer($subscriptionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($subscriptions, $actual);
    }

    public function testTransformEmpty(): void
    {
        $subscriptionTransformer = self::createStub(SubscriptionTransformerInterface::class);

        $transformer = new SubscriptionsTransformer($subscriptionTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $subscription1 = self::createStub(SubscriptionInterface::class);

        $subscriptionTransformer = self::createMock(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->expects(self::once())->method('transform')
            ->with(['test-subscription-1'])
            ->willReturn($subscription1);

        $transformer = new SubscriptionsTransformer($subscriptionTransformer);

        self::assertSame([$subscription1], $transformer->transform([['test-subscription-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $subscriptionTransformer = self::createStub(SubscriptionTransformerInterface::class);

        $transformer = new SubscriptionsTransformer($subscriptionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SubscriptionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SubscriptionsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-subscription-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-subscription-1-array'], 'test-subscription-2-not-array', ['test-subscription-3-array'], 'test-subscription-4-not-array'];

        $subscription1 = self::createStub(SubscriptionInterface::class);
        $subscription3 = self::createStub(SubscriptionInterface::class);

        $subscriptionTransformer = self::createStub(SubscriptionTransformerInterface::class);
        $subscriptionTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-subscription-1-array'], $subscription1],
                    [['test-subscription-3-array'], $subscription3],
                ]
            );

        $transformer = new SubscriptionsTransformer($subscriptionTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SubscriptionsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, SubscriptionsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
