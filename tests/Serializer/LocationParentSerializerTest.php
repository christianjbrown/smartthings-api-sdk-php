<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\LocationParent;
use ChristianBrown\SmartThings\Serializer\LocationParentSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationParent::class)]
#[CoversClass(LocationParentSerializer::class)]
final class LocationParentSerializerTest extends TestCase
{
    public function testOmitsUnsetFields(): void
    {
        self::assertSame([], (new LocationParentSerializer())->serialize(new LocationParent()));
    }

    public function testSerializesTheSetFields(): void
    {
        $parent = (new LocationParent())->setId('test-group')->setType('LOCATIONGROUP');

        self::assertSame(['id' => 'test-group', 'type' => 'LOCATIONGROUP'], (new LocationParentSerializer())->serialize($parent));
    }
}
