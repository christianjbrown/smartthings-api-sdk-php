<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;

interface DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface
{
    public const string KEY_KEY = 'key';
    public const string KEY_REMAINING_TIME = 'remainingTime';
    public const string KEY_TIME = 'time';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
}
