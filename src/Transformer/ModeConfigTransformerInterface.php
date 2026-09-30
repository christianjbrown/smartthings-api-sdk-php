<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ModeConfigInterface;

interface ModeConfigTransformerInterface
{
    public const string KEY_MODE_ID = 'modeId';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ModeConfigInterface;
}
