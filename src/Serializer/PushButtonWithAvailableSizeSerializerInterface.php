<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;

interface PushButtonWithAvailableSizeSerializerInterface
{
    public const string KEY_ARGUMENT = 'argument';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';
    public const string KEY_COMMAND = 'command';
    public const string KEY_ICON_URL = 'iconUrl';

    /**
     * @return mixed[]
     */
    public function serialize(PushButtonWithAvailableSizeInterface $model): array;
}
