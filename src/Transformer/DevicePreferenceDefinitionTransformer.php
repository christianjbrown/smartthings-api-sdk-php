<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinition;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;

use function is_bool;
use function is_string;
use function sprintf;

final class DevicePreferenceDefinitionTransformer implements DevicePreferenceDefinitionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DevicePreferenceDefinitionInterface
    {
        if (empty($data[self::KEY_PREFERENCE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PREFERENCE_ID));
        }
        if (!is_string($data[self::KEY_PREFERENCE_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PREFERENCE_ID));
        }
        $definition = new DevicePreferenceDefinition($data[self::KEY_PREFERENCE_ID]);

        self::applyDescription($definition, $data);
        self::applyName($definition, $data);
        self::applyPreferenceType($definition, $data);
        self::applyRequired($definition, $data);
        self::applyTitle($definition, $data);

        return $definition;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(DevicePreferenceDefinition $definition, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $definition->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(DevicePreferenceDefinition $definition, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $definition->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPreferenceType(DevicePreferenceDefinition $definition, array $data): void
    {
        if (empty($data[self::KEY_PREFERENCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PREFERENCE_TYPE])) {
            return;
        }
        $definition->setPreferenceType($data[self::KEY_PREFERENCE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRequired(DevicePreferenceDefinition $definition, array $data): void
    {
        if (!isset($data[self::KEY_REQUIRED])) {
            return;
        }
        if (!is_bool($data[self::KEY_REQUIRED])) {
            return;
        }
        $definition->setRequired($data[self::KEY_REQUIRED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(DevicePreferenceDefinition $definition, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $definition->setTitle($data[self::KEY_TITLE]);
    }
}
