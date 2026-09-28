<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\LocationPatchField;
use ChristianBrown\SmartThings\Model\PatchLocationRequest;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationPatchField::class)]
#[CoversClass(PatchLocationRequest::class)]
#[CoversClass(PatchLocationRequestSerializer::class)]
final class PatchLocationRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetFields(): void
    {
        $request = new PatchLocationRequest();

        $serializer = new PatchLocationRequestSerializer();

        self::assertSame([], $serializer->serialize($request));
    }

    public function testSerializeWithAllFieldsSetToValues(): void
    {
        $request = (new PatchLocationRequest())
            ->setLatitude(new LocationPatchField(51.5))
            ->setLongitude(new LocationPatchField(-0.1))
            ->setRegionRadius(new LocationPatchField(150.0));

        $serializer = new PatchLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PatchLocationRequestSerializerInterface::KEY_LATITUDE => [PatchLocationRequestSerializerInterface::KEY_VALUE => 51.5],
                PatchLocationRequestSerializerInterface::KEY_LONGITUDE => [PatchLocationRequestSerializerInterface::KEY_VALUE => -0.1],
                PatchLocationRequestSerializerInterface::KEY_REGION_RADIUS => [PatchLocationRequestSerializerInterface::KEY_VALUE => 150.0],
            ],
            $actual
        );
    }

    public function testSerializeWithFieldToNull(): void
    {
        $request = (new PatchLocationRequest())->setLatitude(new LocationPatchField(null, true));

        $serializer = new PatchLocationRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PatchLocationRequestSerializerInterface::KEY_LATITUDE => [PatchLocationRequestSerializerInterface::KEY_TO_NULL => true],
            ],
            $actual
        );
    }
}
