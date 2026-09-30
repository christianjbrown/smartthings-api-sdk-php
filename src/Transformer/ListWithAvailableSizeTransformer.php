<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ListWithAvailableSize;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class ListWithAvailableSizeTransformer implements ListWithAvailableSizeTransformerInterface
{
    private ListWithAvailableSizeCommandTransformerInterface $listWithAvailableSizeCommandTransformer;
    private ListWithAvailableSizeStateTransformerInterface $listWithAvailableSizeStateTransformer;

    public function __construct(ListWithAvailableSizeCommandTransformerInterface $listWithAvailableSizeCommandTransformer, ListWithAvailableSizeStateTransformerInterface $listWithAvailableSizeStateTransformer)
    {
        $this->listWithAvailableSizeCommandTransformer = $listWithAvailableSizeCommandTransformer;
        $this->listWithAvailableSizeStateTransformer = $listWithAvailableSizeStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListWithAvailableSizeInterface
    {
        $model = new ListWithAvailableSize($this->requireCommand($data));

        $this->applyState($model, $data);
        self::applyAvailableSizes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailableSizes(ListWithAvailableSize $model, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        if (!is_array($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        $model->setAvailableSizes(array_values(array_filter($data[self::KEY_AVAILABLE_SIZES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(ListWithAvailableSize $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->listWithAvailableSizeStateTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ?ListWithAvailableSizeCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return null;
        }

        return $this->listWithAvailableSizeCommandTransformer->transform($data[self::KEY_COMMAND]);
    }
}
