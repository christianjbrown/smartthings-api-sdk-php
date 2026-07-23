<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfo;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoSubscriptionInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoSubscriptionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceLocationInfoTransformer::class)]
#[UsesClass(ServiceLocationInfo::class)]
final class ServiceLocationInfoTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransform(): void
    {
        $data = [
            ServiceLocationInfoTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            ServiceLocationInfoTransformerInterface::KEY_CITY => 'Minneapolis',
            ServiceLocationInfoTransformerInterface::KEY_LATITUDE => 44.98,
            ServiceLocationInfoTransformerInterface::KEY_LONGITUDE => -93.27,
            ServiceLocationInfoTransformerInterface::KEY_SUBSCRIPTIONS => ['test-subscription'],
        ];

        $subscriptions = [self::createStub(ServiceLocationInfoSubscriptionInterface::class)];

        $subscriptionsTransformer = self::createMock(ServiceLocationInfoSubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[ServiceLocationInfoTransformerInterface::KEY_SUBSCRIPTIONS])
            ->willReturn($subscriptions);

        $transformer = new ServiceLocationInfoTransformer($subscriptionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('Minneapolis', $actual->getCity());
        self::assertSame(44.98, $actual->getLatitude());
        self::assertSame(-93.27, $actual->getLongitude());
        self::assertSame($subscriptions, $actual->getSubscriptions());
    }

    /**
     * Exercises the optional city field and the int/float/absent/wrong-type
     * branches of latitude and longitude.
     *
     * @param array<string, mixed> $data
     *
     * @throws Exception
     */
    #[DataProvider('provideTransformScalarFieldsCases')]
    public function testTransformScalarFields(array $data, ?string $expectedCity, ?float $expectedLatitude, ?float $expectedLongitude): void
    {
        $subscriptionsTransformer = self::createMock(ServiceLocationInfoSubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ServiceLocationInfoTransformer($subscriptionsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame($expectedCity, $actual->getCity());
        self::assertSame($expectedLatitude, $actual->getLatitude());
        self::assertSame($expectedLongitude, $actual->getLongitude());
        self::assertSame([], $actual->getSubscriptions());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?float, ?float}>
     */
    public static function provideTransformScalarFieldsCases(): iterable
    {
        $id = ServiceLocationInfoTransformerInterface::KEY_LOCATION_ID;
        $city = ServiceLocationInfoTransformerInterface::KEY_CITY;
        $latitude = ServiceLocationInfoTransformerInterface::KEY_LATITUDE;
        $longitude = ServiceLocationInfoTransformerInterface::KEY_LONGITUDE;

        yield 'allAbsent' => [[$id => 'test-location-id'], null, null, null];
        yield 'cityValid' => [[$id => 'test-location-id', $city => 'Minneapolis'], 'Minneapolis', null, null];
        yield 'cityWrongType' => [[$id => 'test-location-id', $city => 42], null, null, null];
        yield 'latitudeInt' => [[$id => 'test-location-id', $latitude => 44], null, 44.0, null];
        yield 'latitudeFloat' => [[$id => 'test-location-id', $latitude => 44.98], null, 44.98, null];
        yield 'latitudeWrongType' => [[$id => 'test-location-id', $latitude => 'not-a-number'], null, null, null];
        yield 'longitudeInt' => [[$id => 'test-location-id', $longitude => -93], null, null, -93.0];
        yield 'longitudeFloat' => [[$id => 'test-location-id', $longitude => -93.27], null, null, -93.27];
        yield 'longitudeWrongType' => [[$id => 'test-location-id', $longitude => 'not-a-number'], null, null, null];
    }

    /**
     * @throws Exception
     */
    public function testTransformSubscriptionsNonArray(): void
    {
        $subscriptionsTransformer = self::createMock(ServiceLocationInfoSubscriptionsTransformerInterface::class);
        $subscriptionsTransformer->expects(self::never())
            ->method('transform');

        $transformer = new ServiceLocationInfoTransformer($subscriptionsTransformer);

        $actual = $transformer->transform([
            ServiceLocationInfoTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            ServiceLocationInfoTransformerInterface::KEY_SUBSCRIPTIONS => 'not-an-array',
        ]);

        self::assertSame([], $actual->getSubscriptions());
    }

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    #[TestWith([[]])]
    #[TestWith([[ServiceLocationInfoTransformerInterface::KEY_LOCATION_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ServiceLocationInfoTransformer(self::createStub(ServiceLocationInfoSubscriptionsTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ServiceLocationInfoTransformerInterface::UNEXPECTED_STRING_SPRINTF, ServiceLocationInfoTransformerInterface::KEY_LOCATION_ID));
        $transformer->transform($data);
    }
}
