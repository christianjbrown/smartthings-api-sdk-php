<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Capability;
use ChristianBrown\SmartThings\Model\CapabilityInterface;

use function is_int;
use function is_string;
use function sprintf;

final class CapabilityTransformer implements CapabilityTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $capability = new Capability($data[self::KEY_ID]);

        self::applyName($capability, $data);
        self::applyStatus($capability, $data);
        self::applyVersion($capability, $data);

        return $capability;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Capability $capability, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $capability->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(Capability $capability, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $capability->setStatus($data[self::KEY_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(Capability $capability, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $capability->setVersion($data[self::KEY_VERSION]);
    }
}
