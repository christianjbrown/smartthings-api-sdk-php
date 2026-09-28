<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\CoordinateAliasRequest;
use ChristianBrown\SmartThings\Serializer\CoordinateAliasRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CoordinateAliasRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoordinateAliasRequest::class)]
#[CoversClass(CoordinateAliasRequestSerializer::class)]
final class CoordinateAliasRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CoordinateAliasRequest(1.5, 1.5, 7);

        $serializer = new CoordinateAliasRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CoordinateAliasRequestSerializerInterface::KEY_LATITUDE => 1.5,
                CoordinateAliasRequestSerializerInterface::KEY_LONGITUDE => 1.5,
                CoordinateAliasRequestSerializerInterface::KEY_REGION_RADIUS => 7,
            ],
            $actual
        );
    }
}
