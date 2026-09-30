<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CreateLocationRequest;
use ChristianBrown\SmartThings\Model\LocationParent;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\LocationParentSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateLocationRequest::class)]
#[CoversClass(CreateLocationRequestSerializer::class)]
#[CoversClass(LocationParent::class)]
#[CoversClass(LocationParentSerializer::class)]
final class CreateLocationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateLocationRequest('Home', 'GBR');

        $serializer = new CreateLocationRequestSerializer(new LocationParentSerializer());

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

        $serializer = new CreateLocationRequestSerializer(new LocationParentSerializer());

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

    public function testSerializeWithAParentAndAdditionalProperties(): void
    {
        $request = (new CreateLocationRequest('Home', 'GBR'))
            ->setParent((new LocationParent())->setId('test-group')->setType('LOCATIONGROUP'))
            ->setAdditionalProperties(['floors' => '2']);

        $actual = (new CreateLocationRequestSerializer(new LocationParentSerializer()))->serialize($request);

        self::assertSame(
            [
                CreateLocationRequestSerializerInterface::KEY_NAME => 'Home',
                CreateLocationRequestSerializerInterface::KEY_COUNTRY_CODE => 'GBR',
                CreateLocationRequestSerializerInterface::KEY_ADDITIONAL_PROPERTIES => ['floors' => '2'],
                CreateLocationRequestSerializerInterface::KEY_PARENT => ['id' => 'test-group', 'type' => 'LOCATIONGROUP'],
            ],
            $actual
        );
    }
}
