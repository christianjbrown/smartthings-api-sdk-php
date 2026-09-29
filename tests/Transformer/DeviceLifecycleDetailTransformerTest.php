<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceLifecycleDetail;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceLifecycleDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceLifecycleDetail::class)]
#[CoversClass(DeviceLifecycleDetailTransformer::class)]
final class DeviceLifecycleDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceLifecycleDetailTransformerInterface::KEY_DEVICE_IDS => ['test-device-ids-1', 'test-device-ids-2'],
            DeviceLifecycleDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name',
            DeviceLifecycleDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new DeviceLifecycleDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['test-device-ids-1', 'test-device-ids-2'], $actual->getDeviceIds());
        self::assertSame('test-subscription-name', $actual->getSubscriptionName());
        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceLifecycleDetailTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceIdsAbsent' => [[], 'getDeviceIds', null];
        yield 'deviceIdsWrongType' => [[DeviceLifecycleDetailTransformerInterface::KEY_DEVICE_IDS => 'not-array'], 'getDeviceIds', null];
        yield 'deviceIdsValid' => [[DeviceLifecycleDetailTransformerInterface::KEY_DEVICE_IDS => ['test-device-ids-1', 'test-device-ids-2']], 'getDeviceIds', ['test-device-ids-1', 'test-device-ids-2']];
        yield 'subscriptionNameAbsent' => [[], 'getSubscriptionName', null];
        yield 'subscriptionNameWrongType' => [[DeviceLifecycleDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 42], 'getSubscriptionName', null];
        yield 'subscriptionNameValid' => [[DeviceLifecycleDetailTransformerInterface::KEY_SUBSCRIPTION_NAME => 'test-subscription-name'], 'getSubscriptionName', 'test-subscription-name'];
        yield 'locationIdAbsent' => [[], 'getLocationId', null];
        yield 'locationIdWrongType' => [[DeviceLifecycleDetailTransformerInterface::KEY_LOCATION_ID => 42], 'getLocationId', null];
        yield 'locationIdValid' => [[DeviceLifecycleDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id'], 'getLocationId', 'test-location-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceLifecycleDetailTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDeviceIds());
        self::assertNull($actual->getSubscriptionName());
        self::assertNull($actual->getLocationId());
    }
}
