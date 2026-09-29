<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledSchemaAppDetailsInterface;

interface InstalledSchemaAppDetailsTransformerInterface
{
    public const string KEY_DEVICES = 'devices';
    public const string KEY_VIPER_APP_LINKS = 'viperAppLinks';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledSchemaAppDetailsInterface;
}
