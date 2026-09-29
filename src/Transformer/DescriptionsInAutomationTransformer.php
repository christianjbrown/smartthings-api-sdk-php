<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DescriptionItemInterface;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomation;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DescriptionsInAutomationTransformer implements DescriptionsInAutomationTransformerInterface
{
    private DescriptionItemTransformerInterface $descriptionItemTransformer;

    public function __construct(DescriptionItemTransformerInterface $descriptionItemTransformer)
    {
        $this->descriptionItemTransformer = $descriptionItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DescriptionsInAutomationInterface
    {
        $model = new DescriptionsInAutomation();

        $this->applyConditions($model, $data);
        $this->applyActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(DescriptionsInAutomation $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListDescriptionItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditions(DescriptionsInAutomation $model, array $data): void
    {
        if (!isset($data[self::KEY_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONDITIONS])) {
            return;
        }
        $model->setConditions($this->transformListDescriptionItem($data[self::KEY_CONDITIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DescriptionItemInterface>
     */
    private function transformListDescriptionItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DescriptionItemInterface => $this->descriptionItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
