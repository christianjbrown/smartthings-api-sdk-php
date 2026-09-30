<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntry;
use ChristianBrown\SmartThings\Model\DeviceConfigInterface;
use ChristianBrown\SmartThings\Model\MessageConfigInterface;
use ChristianBrown\SmartThings\Model\ModeConfigInterface;
use ChristianBrown\SmartThings\Model\PermissionConfigInterface;
use ChristianBrown\SmartThings\Model\RoomConfigInterface;
use ChristianBrown\SmartThings\Model\SceneConfigInterface;
use ChristianBrown\SmartThings\Model\StringConfigInterface;
use ChristianBrown\SmartThings\Transformer\ConfigEntryTransformer;
use ChristianBrown\SmartThings\Transformer\ConfigEntryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MessageConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PermissionConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RoomConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SceneConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StringConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigEntryTransformer::class)]
#[CoversClass(ConfigEntry::class)]
#[CoversClass(ValueReader::class)]
final class ConfigEntryTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformLeavesMissingPartsUnset(): void
    {
        $actual = (new ConfigEntryTransformer(new ValueReader(), self::createStub(StringConfigTransformerInterface::class), self::createStub(DeviceConfigTransformerInterface::class), self::createStub(PermissionConfigTransformerInterface::class), self::createStub(ModeConfigTransformerInterface::class), self::createStub(SceneConfigTransformerInterface::class), self::createStub(MessageConfigTransformerInterface::class), self::createStub(RoomConfigTransformerInterface::class)))->transform([]);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getStringConfig());
        self::assertNull($actual->getDeviceConfig());
        self::assertNull($actual->getRoomConfig());
    }

    /**
     * @throws Exception
     */
    public function testTransformReadsEveryKindOfEntry(): void
    {
        $string = self::createStub(StringConfigInterface::class);
        $device = self::createStub(DeviceConfigInterface::class);
        $permission = self::createStub(PermissionConfigInterface::class);
        $mode = self::createStub(ModeConfigInterface::class);
        $scene = self::createStub(SceneConfigInterface::class);
        $message = self::createStub(MessageConfigInterface::class);
        $room = self::createStub(RoomConfigInterface::class);

        $stringTransformer = self::createStub(StringConfigTransformerInterface::class);
        $stringTransformer->method('transform')->willReturn($string);
        $deviceTransformer = self::createStub(DeviceConfigTransformerInterface::class);
        $deviceTransformer->method('transform')->willReturn($device);
        $permissionTransformer = self::createStub(PermissionConfigTransformerInterface::class);
        $permissionTransformer->method('transform')->willReturn($permission);
        $modeTransformer = self::createStub(ModeConfigTransformerInterface::class);
        $modeTransformer->method('transform')->willReturn($mode);
        $sceneTransformer = self::createStub(SceneConfigTransformerInterface::class);
        $sceneTransformer->method('transform')->willReturn($scene);
        $messageTransformer = self::createStub(MessageConfigTransformerInterface::class);
        $messageTransformer->method('transform')->willReturn($message);
        $roomTransformer = self::createStub(RoomConfigTransformerInterface::class);
        $roomTransformer->method('transform')->willReturn($room);

        $actual = (new ConfigEntryTransformer(new ValueReader(), $stringTransformer, $deviceTransformer, $permissionTransformer, $modeTransformer, $sceneTransformer, $messageTransformer, $roomTransformer))->transform([
            ConfigEntryTransformerInterface::KEY_VALUE_TYPE => 'DEVICE',
            ConfigEntryTransformerInterface::KEY_STRING_CONFIG => ['value' => 'x'],
            ConfigEntryTransformerInterface::KEY_DEVICE_CONFIG => ['deviceId' => 'd'],
            ConfigEntryTransformerInterface::KEY_PERMISSION_CONFIG => ['permissions' => []],
            ConfigEntryTransformerInterface::KEY_MODE_CONFIG => ['modeId' => 'm'],
            ConfigEntryTransformerInterface::KEY_SCENE_CONFIG => ['sceneId' => 's'],
            ConfigEntryTransformerInterface::KEY_MESSAGE_CONFIG => ['messageGroupKey' => 'g'],
            ConfigEntryTransformerInterface::KEY_ROOM_CONFIG => ['roomId' => 'r'],
        ]);

        self::assertSame('DEVICE', $actual->getValueType());
        self::assertSame($string, $actual->getStringConfig());
        self::assertSame($device, $actual->getDeviceConfig());
        self::assertSame($permission, $actual->getPermissionConfig());
        self::assertSame($mode, $actual->getModeConfig());
        self::assertSame($scene, $actual->getSceneConfig());
        self::assertSame($message, $actual->getMessageConfig());
        self::assertSame($room, $actual->getRoomConfig());
    }
}
