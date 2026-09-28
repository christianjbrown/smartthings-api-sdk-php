<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateLocationRequest;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateLocationRequest::class)]
#[CoversClass(CreateLocationRequestSerializer::class)]
final class CreateLocationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateLocationRequest('Home', 'GBR');

        $serializer = new CreateLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateLocationRequestSerializerInterface::KEY_NAME => 'Home',
                CreateLocationRequestSerializerInterface::KEY_COUNTRY_CODE => 'GBR',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CreateLocationRequest('Home', 'GBR'))
            ->setLatitude(51.5)
            ->setLongitude(-0.1)
            ->setRegionRadius(150)
            ->setTemperatureScale('C')
            ->setTimeZoneId('Europe/London')
            ->setLocale('en_GB');

        $serializer = new CreateLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateLocationRequestSerializerInterface::KEY_NAME => 'Home',
                CreateLocationRequestSerializerInterface::KEY_COUNTRY_CODE => 'GBR',
                CreateLocationRequestSerializerInterface::KEY_LATITUDE => 51.5,
                CreateLocationRequestSerializerInterface::KEY_LONGITUDE => -0.1,
                CreateLocationRequestSerializerInterface::KEY_REGION_RADIUS => 150,
                CreateLocationRequestSerializerInterface::KEY_TEMPERATURE_SCALE => 'C',
                CreateLocationRequestSerializerInterface::KEY_TIME_ZONE_ID => 'Europe/London',
                CreateLocationRequestSerializerInterface::KEY_LOCALE => 'en_GB',
            ],
            $actual
        );
    }
}
