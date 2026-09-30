<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\RoomConfig;
use ChristianBrown\SmartThings\Transformer\RoomConfigTransformer;
use ChristianBrown\SmartThings\Transformer\RoomConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoomConfigTransformer::class)]
#[CoversClass(RoomConfig::class)]
#[CoversClass(ValueReader::class)]
final class RoomConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new RoomConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getRoomId());
        self::assertSame([], $actual->getPermissions());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new RoomConfigTransformer(new ValueReader()))->transform([
            RoomConfigTransformerInterface::KEY_ROOM_ID => 'test-roomId',
            RoomConfigTransformerInterface::KEY_PERMISSIONS => ['test-permissions-1', 'test-permissions-2'],
        ]);

        self::assertSame('test-roomId', $actual->getRoomId());
        self::assertSame(['test-permissions-1', 'test-permissions-2'], $actual->getPermissions());
    }
}
