<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceStatusReportInterface;

interface DeviceStatusReportTransformerInterface
{
    public const string KEY_COMPONENTS = 'components';
    public const string KEY_HEALTH_STATE = 'healthState';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusReportInterface;
}
