<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppSettingsInterface;

interface AppSettingsTransformerInterface
{
    public const string KEY_SETTINGS = 'settings';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppSettingsInterface;
}
