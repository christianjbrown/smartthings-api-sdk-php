<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;

interface DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeTransformerInterface
{
    public const string KEY_FREQUENCY = 'frequency';
    public const string KEY_TIME_FORMAT = 'timeFormat';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;
}
