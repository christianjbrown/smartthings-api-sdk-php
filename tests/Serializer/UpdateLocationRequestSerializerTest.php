<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateLocationRequest;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateLocationRequest::class)]
#[CoversClass(UpdateLocationRequestSerializer::class)]
final class UpdateLocationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateLocationRequest('Home');

        $serializer = new UpdateLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [UpdateLocationRequestSerializerInterface::KEY_NAME => 'Home'],
            $actual
        );
    }

    public function testSerializeWithAdditionalProperties(): void
    {
        $request = (new UpdateLocationRequest('Home'))->setAdditionalProperties(['floors' => '2']);

        self::assertSame(
            [
                UpdateLocationRequestSerializerInterface::KEY_NAME => 'Home',
                UpdateLocationRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => ['floors' => '2'],
            ],
            (new UpdateLocationRequestSerializer())->serialize($request)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateLocationRequest('Home'))
            ->setLatitude(51.5)
            ->setLongitude(-0.1)
            ->setRegionRadius(150)
            ->setTemperatureScale('C')
            ->setTimeZoneId('Europe/London')
            ->setLocale('en_GB');

        $serializer = new UpdateLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateLocationRequestSerializerInterface::KEY_NAME => 'Home',
                UpdateLocationRequestSerializerInterface::KEY_LATITUDE => 51.5,
                UpdateLocationRequestSerializerInterface::KEY_LONGITUDE => -0.1,
                UpdateLocationRequestSerializerInterface::KEY_REGION_RADIUS => 150,
                UpdateLocationRequestSerializerInterface::KEY_TEMPERATURE_SCALE => 'C',
                UpdateLocationRequestSerializerInterface::KEY_TIME_ZONE_ID => 'Europe/London',
                UpdateLocationRequestSerializerInterface::KEY_LOCALE => 'en_GB',
            ],
            $actual
        );
    }
}
