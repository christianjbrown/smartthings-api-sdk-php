<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceipt;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceSubscriptionReceipt::class)]
#[CoversClass(ServiceSubscriptionReceiptTransformer::class)]
final class ServiceSubscriptionReceiptTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ServiceSubscriptionReceiptTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            ServiceSubscriptionReceiptTransformerInterface::KEY_SUBSCRIPTION_ID => 'test-subscription-id',
        ];

        $transformer = new ServiceSubscriptionReceiptTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('test-subscription-id', $actual->getSubscriptionId());
    }

    public function testTransformLocationIdAbsent(): void
    {
        $transformer = new ServiceSubscriptionReceiptTransformer();

        self::assertNull($transformer->transform([])->getLocationId());
    }

    public function testTransformLocationIdWrongType(): void
    {
        $transformer = new ServiceSubscriptionReceiptTransformer();

        self::assertNull($transformer->transform([ServiceSubscriptionReceiptTransformerInterface::KEY_LOCATION_ID => 42])->getLocationId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ServiceSubscriptionReceiptTransformer();

        $actual = $transformer->transform([ServiceSubscriptionReceiptTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'subscriptionIdAbsent' => [[], 'getSubscriptionId', null];
        yield 'subscriptionIdWrongType' => [[ServiceSubscriptionReceiptTransformerInterface::KEY_SUBSCRIPTION_ID => 42], 'getSubscriptionId', null];
        yield 'subscriptionIdValid' => [[ServiceSubscriptionReceiptTransformerInterface::KEY_SUBSCRIPTION_ID => 'test-subscription-id'], 'getSubscriptionId', 'test-subscription-id'];
    }
}
