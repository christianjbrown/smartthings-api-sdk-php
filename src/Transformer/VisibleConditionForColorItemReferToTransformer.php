<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferTo;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;

use function is_int;
use function is_string;
use function sprintf;

final class VisibleConditionForColorItemReferToTransformer implements VisibleConditionForColorItemReferToTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForColorItemReferToInterface
    {
        $model = new VisibleConditionForColorItemReferTo(self::requireComponent($data), self::requireCapability($data), self::requireValue($data));

        self::applyVersion($model, $data);
        self::applyValueType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(VisibleConditionForColorItemReferTo $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(VisibleConditionForColorItemReferTo $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
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
    private static function requireComponent(array $data): string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): string
    {
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }

        return $data[self::KEY_VALUE];
    }
}
