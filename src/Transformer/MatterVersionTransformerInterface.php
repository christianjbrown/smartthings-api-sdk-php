<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterVersionInterface;

interface MatterVersionTransformerInterface
{
    public const string KEY_HARDWARE = 'hardware';
    public const string KEY_HARDWARE_LABEL = 'hardwareLabel';
    public const string KEY_SOFTWARE = 'software';
    public const string KEY_SOFTWARE_LABEL = 'softwareLabel';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterVersionInterface;
}
