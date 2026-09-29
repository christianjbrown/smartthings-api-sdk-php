<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetail;
use ChristianBrown\SmartThings\Model\CapabilitySubscriptionDetailInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class CapabilitySubscriptionDetailTransformer implements CapabilitySubscriptionDetailTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilitySubscriptionDetailInterface
    {
        $model = new CapabilitySubscriptionDetail(self::requireLocationId($data), self::requireCapability($data));

        self::applyAttribute($model, $data);
        self::applyValue($model, $data);
        self::applyStateChangeOnly($model, $data);
        self::applySubscriptionName($model, $data);
        self::applyModes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAttribute(CapabilitySubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        if (!is_string($data[self::KEY_ATTRIBUTE])) {
            return;
        }
        $model->setAttribute($data[self::KEY_ATTRIBUTE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyModes(CapabilitySubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_MODES])) {
            return;
        }
        if (!is_array($data[self::KEY_MODES])) {
            return;
        }
        $model->setModes(array_values(array_filter($data[self::KEY_MODES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateChangeOnly(CapabilitySubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE_CHANGE_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_STATE_CHANGE_ONLY])) {
            return;
        }
        $model->setStateChangeOnly($data[self::KEY_STATE_CHANGE_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionName(CapabilitySubscriptionDetail $model, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_NAME])) {
            return;
        }
        $model->setSubscriptionName($data[self::KEY_SUBSCRIPTION_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(CapabilitySubscriptionDetail $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLocationId(array $data): string
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }

        return $data[self::KEY_LOCATION_ID];
    }
}
