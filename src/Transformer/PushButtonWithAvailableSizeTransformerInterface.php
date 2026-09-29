<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;

interface PushButtonWithAvailableSizeTransformerInterface
{
    public const string KEY_ARGUMENT = 'argument';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_AVAILABLE_SIZES = 'availableSizes';
    public const string KEY_COMMAND = 'command';
    public const string KEY_ICON_URL = 'iconUrl';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PushButtonWithAvailableSizeInterface;
}
