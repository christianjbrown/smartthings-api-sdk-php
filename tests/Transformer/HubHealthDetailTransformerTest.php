<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\HubHealthDetail;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformer;
use ChristianBrown\SmartThings\Transformer\HubHealthDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubHealthDetail::class)]
#[CoversClass(HubHealthDetailTransformer::class)]
final class HubHealthDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'locationIdAbsent' => [[], 'getLocationId', null];
        yield 'locationIdWrongType' => [[HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 42], 'getLocationId', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform([HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[HubHealthDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new HubHealthDetailTransformer();

        $actual = $transformer->transform([HubHealthDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id']);

        self::assertNull($actual->getSubscriptionName());
    }
}
