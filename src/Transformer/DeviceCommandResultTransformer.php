<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCommandResult;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;

use function is_string;

final class DeviceCommandResultTransformer implements DeviceCommandResultTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCommandResultInterface
    {
        $result = new DeviceCommandResult();

        self::applyId($result, $data);
        self::applyStatus($result, $data);

        return $result;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(DeviceCommandResult $result, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $result->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(DeviceCommandResult $result, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $result->setStatus($data[self::KEY_STATUS]);
    }
}
