<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;

interface DeviceCommandResultTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_STATUS = 'status';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCommandResultInterface;
}
