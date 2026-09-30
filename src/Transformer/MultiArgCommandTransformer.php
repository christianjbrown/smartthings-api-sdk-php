<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MultiArgCommand;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class MultiArgCommandTransformer implements MultiArgCommandTransformerInterface
{
    private MultiArgCommandArgumentsItemTransformerInterface $multiArgCommandArgumentsItemTransformer;

    public function __construct(MultiArgCommandArgumentsItemTransformerInterface $multiArgCommandArgumentsItemTransformer)
    {
        $this->multiArgCommandArgumentsItemTransformer = $multiArgCommandArgumentsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MultiArgCommandInterface
    {
        $model = new MultiArgCommand(self::requireCommand($data), $this->requireArguments($data));

        self::applySupportedValues($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(MultiArgCommand $model, array $data): void
    {
        if (empty($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        if (!is_string($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        $model->setSupportedValues($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, MultiArgCommandArgumentsItemInterface>
     */
    private function requireArguments(array $data): array
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return [];
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return [];
        }

        return $this->transformListMultiArgCommandArgumentsItem($data[self::KEY_ARGUMENTS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, MultiArgCommandArgumentsItemInterface>
     */
    private function transformListMultiArgCommandArgumentsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): MultiArgCommandArgumentsItemInterface => $this->multiArgCommandArgumentsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
