<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTime;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;

use function is_string;
use function sprintf;

final class DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformer implements DeviceConfigEntryForDashboardStateFormatInfoItemTimeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface
    {
        $model = new DeviceConfigEntryForDashboardStateFormatInfoItemTime(self::requireTimeFormat($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTimeFormat(array $data): string
    {
        if (empty($data[self::KEY_TIME_FORMAT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME_FORMAT));
        }
        if (!is_string($data[self::KEY_TIME_FORMAT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TIME_FORMAT));
        }

        return $data[self::KEY_TIME_FORMAT];
    }
}
