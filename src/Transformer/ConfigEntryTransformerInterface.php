<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntryInterface;

interface ConfigEntryTransformerInterface
{
    public const string KEY_DEVICE_CONFIG = 'deviceConfig';
    public const string KEY_MESSAGE_CONFIG = 'messageConfig';
    public const string KEY_MODE_CONFIG = 'modeConfig';
    public const string KEY_PERMISSION_CONFIG = 'permissionConfig';
    public const string KEY_ROOM_CONFIG = 'roomConfig';
    public const string KEY_SCENE_CONFIG = 'sceneConfig';
    public const string KEY_STRING_CONFIG = 'stringConfig';
    public const string KEY_VALUE_TYPE = 'valueType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConfigEntryInterface;
}
