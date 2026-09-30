<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationAction;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DynamicListForAutomationActionTransformer implements DynamicListForAutomationActionTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private SupportedValuesForDynamicListTransformerInterface $supportedValuesForDynamicListTransformer;

    public function __construct(SupportedValuesForDynamicListTransformerInterface $supportedValuesForDynamicListTransformer, AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->supportedValuesForDynamicListTransformer = $supportedValuesForDynamicListTransformer;
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DynamicListForAutomationActionInterface
    {
        $model = new DynamicListForAutomationAction($this->requireSupportedValues($data));

        self::applyCommand($model, $data);
        self::applyArgumentType($model, $data);
        $this->applyAlternatives($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(DynamicListForAutomationAction $model, array $data): void
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        $model->setAlternatives($this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(DynamicListForAutomationAction $model, array $data): void
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
    private static function applyCommand(DynamicListForAutomationAction $model, array $data): void
    {
        if (empty($data[self::KEY_COMMAND])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return;
        }
        $model->setCommand($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireSupportedValues(array $data): ?SupportedValuesForDynamicListInterface
    {
        if (!isset($data[self::KEY_SUPPORTED_VALUES])) {
            return null;
        }
        if (!is_array($data[self::KEY_SUPPORTED_VALUES])) {
            return null;
        }

        return $this->supportedValuesForDynamicListTransformer->transform($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
