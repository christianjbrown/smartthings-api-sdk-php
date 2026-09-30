<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntry;
use ChristianBrown\SmartThings\Model\ConfigEntryInterface;

use function array_keys;
use function array_map;

final class ConfigEntryTransformer implements ConfigEntryTransformerInterface
{
    /**
     * @var array<string, callable(ConfigEntryInterface, mixed[]): ConfigEntryInterface>
     */
    private array $partAppliers;
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader, StringConfigTransformerInterface $stringConfigTransformer, DeviceConfigTransformerInterface $deviceConfigTransformer, PermissionConfigTransformerInterface $permissionConfigTransformer, ModeConfigTransformerInterface $modeConfigTransformer, SceneConfigTransformerInterface $sceneConfigTransformer, MessageConfigTransformerInterface $messageConfigTransformer, RoomConfigTransformerInterface $roomConfigTransformer)
    {
        $this->valueReader = $valueReader;
        // Each part registers a `key => applier` here; a new kind of entry is one more
        // line, and transform() never changes.
        $this->partAppliers = [
            self::KEY_STRING_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setStringConfig($stringConfigTransformer->transform($part)),
            self::KEY_DEVICE_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setDeviceConfig($deviceConfigTransformer->transform($part)),
            self::KEY_PERMISSION_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setPermissionConfig($permissionConfigTransformer->transform($part)),
            self::KEY_MODE_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setModeConfig($modeConfigTransformer->transform($part)),
            self::KEY_SCENE_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setSceneConfig($sceneConfigTransformer->transform($part)),
            self::KEY_MESSAGE_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setMessageConfig($messageConfigTransformer->transform($part)),
            self::KEY_ROOM_CONFIG => static fn (ConfigEntryInterface $entry, array $part): ConfigEntryInterface => $entry->setRoomConfig($roomConfigTransformer->transform($part)),
        ];
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConfigEntryInterface
    {
        $entry = (new ConfigEntry())->setValueType($this->valueReader->string($data, self::KEY_VALUE_TYPE));

        array_map(
            fn (string $key): ConfigEntryInterface => $this->applyPart($entry, $data, $key),
            array_keys($this->partAppliers)
        );

        return $entry;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPart(ConfigEntryInterface $entry, array $data, string $key): ConfigEntryInterface
    {
        $part = $this->valueReader->record($data, $key);
        if (null === $part) {
            return $entry;
        }

        return $this->partAppliers[$key]($entry, $part);
    }
}
