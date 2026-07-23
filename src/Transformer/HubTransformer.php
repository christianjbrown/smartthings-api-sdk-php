<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Hub;
use ChristianBrown\SmartThings\Model\HubInterface;

use function is_string;
use function sprintf;

final class HubTransformer implements HubTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $hub = new Hub($data[self::KEY_ID]);

        self::applyEui($hub, $data);
        self::applyFirmwareVersion($hub, $data);
        self::applyName($hub, $data);
        self::applyOwner($hub, $data);
        self::applySerialNumber($hub, $data);

        return $hub;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEui(Hub $hub, array $data): void
    {
        if (empty($data[self::KEY_EUI])) {
            return;
        }
        if (!is_string($data[self::KEY_EUI])) {
            return;
        }
        $hub->setEui($data[self::KEY_EUI]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFirmwareVersion(Hub $hub, array $data): void
    {
        if (empty($data[self::KEY_FIRMWARE_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_FIRMWARE_VERSION])) {
            return;
        }
        $hub->setFirmwareVersion($data[self::KEY_FIRMWARE_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Hub $hub, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $hub->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOwner(Hub $hub, array $data): void
    {
        if (empty($data[self::KEY_OWNER])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER])) {
            return;
        }
        $hub->setOwner($data[self::KEY_OWNER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySerialNumber(Hub $hub, array $data): void
    {
        if (empty($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        $hub->setSerialNumber($data[self::KEY_SERIAL_NUMBER]);
    }
}
