<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ListForPanelItem;
use ChristianBrown\SmartThings\Model\ListForPanelItemCommandInterface;
use ChristianBrown\SmartThings\Model\ListForPanelItemInterface;

use function is_array;
use function is_string;

final class ListForPanelItemTransformer implements ListForPanelItemTransformerInterface
{
    private ListForPanelItemCommandTransformerInterface $listForPanelItemCommandTransformer;
    private ListForPanelItemStateTransformerInterface $listForPanelItemStateTransformer;

    public function __construct(ListForPanelItemCommandTransformerInterface $listForPanelItemCommandTransformer, ListForPanelItemStateTransformerInterface $listForPanelItemStateTransformer)
    {
        $this->listForPanelItemCommandTransformer = $listForPanelItemCommandTransformer;
        $this->listForPanelItemStateTransformer = $listForPanelItemStateTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListForPanelItemInterface
    {
        $model = new ListForPanelItem($this->requireCommand($data), self::requireSize($data));

        $this->applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(ListForPanelItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->listForPanelItemStateTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @param mixed[] $data
     */
    private function requireCommand(array $data): ?ListForPanelItemCommandInterface
    {
        if (!isset($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_array($data[self::KEY_COMMAND])) {
            return null;
        }

        return $this->listForPanelItemCommandTransformer->transform($data[self::KEY_COMMAND]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSize(array $data): ?string
    {
        if (empty($data[self::KEY_SIZE])) {
            return null;
        }
        if (!is_string($data[self::KEY_SIZE])) {
            return null;
        }

        return $data[self::KEY_SIZE];
    }
}
