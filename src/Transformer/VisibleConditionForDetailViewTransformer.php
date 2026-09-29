<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailView;
use ChristianBrown\SmartThings\Model\VisibleConditionForDetailViewInterface;

use function is_bool;
use function is_int;
use function is_string;
use function sprintf;

final class VisibleConditionForDetailViewTransformer implements VisibleConditionForDetailViewTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): VisibleConditionForDetailViewInterface
    {
        $model = new VisibleConditionForDetailView(self::requireValue($data), self::requireOperator($data), self::requireOperand($data), self::requireComponent($data), self::requireCapability($data));

        self::applyValueType($model, $data);
        self::applyVersion($model, $data);
        self::applyHideOnUnmatch($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideOnUnmatch(VisibleConditionForDetailView $model, array $data): void
    {
        if (!isset($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        if (!is_bool($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        $model->setHideOnUnmatch($data[self::KEY_HIDE_ON_UNMATCH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(VisibleConditionForDetailView $model, array $data): void
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
    private static function applyVersion(VisibleConditionForDetailView $model, array $data): void
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
    private static function requireOperand(array $data): string
    {
        if (empty($data[self::KEY_OPERAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERAND));
        }
        if (!is_string($data[self::KEY_OPERAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERAND));
        }

        return $data[self::KEY_OPERAND];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperator(array $data): string
    {
        if (empty($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }

        return $data[self::KEY_OPERATOR];
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
