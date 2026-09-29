<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItem;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class BasicPlusItemActionsItemTransformer implements BasicPlusItemActionsItemTransformerInterface
{
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemActionsItemInterface
    {
        $model = new BasicPlusItemActionsItem(self::requireCommand($data), self::requireComponent($data), self::requireCapability($data));

        self::applyArgument($model, $data);
        self::applyArgumentType($model, $data);
        self::applyIconUrl($model, $data);
        self::applyVersion($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgument(BasicPlusItemActionsItem $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT])) {
            return;
        }
        $model->setArgument($data[self::KEY_ARGUMENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(BasicPlusItemActionsItem $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        $model->setArgumentType($data[self::KEY_ARGUMENT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(BasicPlusItemActionsItem $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(BasicPlusItemActionsItem $model, array $data): void
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return;
        }
        $model->setOperator($data[self::KEY_OPERATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(BasicPlusItemActionsItem $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleConditions(BasicPlusItemActionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setVisibleConditions($this->transformListVisibleCondition($data[self::KEY_VISIBLE_CONDITIONS]));
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
    private static function requireCommand(array $data): string
    {
        if (empty($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMMAND));
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMMAND));
        }

        return $data[self::KEY_COMMAND];
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
     *
     * @return array<int, VisibleConditionInterface>
     */
    private function transformListVisibleCondition(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionInterface => $this->visibleConditionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
