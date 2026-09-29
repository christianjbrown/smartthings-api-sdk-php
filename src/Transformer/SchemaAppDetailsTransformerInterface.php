<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppDetailsInterface;

interface SchemaAppDetailsTransformerInterface
{
    public const string KEY_VIPER_APP_LINKS = 'viperAppLinks';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppDetailsInterface;
}
