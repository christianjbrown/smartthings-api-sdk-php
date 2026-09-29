<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomation;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DeviceConfigurationAutomationTransformer implements DeviceConfigurationAutomationTransformerInterface
{
    private DescriptionsInAutomationTransformerInterface $descriptionsInAutomationTransformer;
    private ExcludedDeviceActionConfigEntryTransformerInterface $excludedDeviceActionConfigEntryTransformer;
    private ExcludedDeviceConditionConfigEntryTransformerInterface $excludedDeviceConditionConfigEntryTransformer;

    public function __construct(ExcludedDeviceConditionConfigEntryTransformerInterface $excludedDeviceConditionConfigEntryTransformer, ExcludedDeviceActionConfigEntryTransformerInterface $excludedDeviceActionConfigEntryTransformer, DescriptionsInAutomationTransformerInterface $descriptionsInAutomationTransformer)
    {
        $this->excludedDeviceConditionConfigEntryTransformer = $excludedDeviceConditionConfigEntryTransformer;
        $this->excludedDeviceActionConfigEntryTransformer = $excludedDeviceActionConfigEntryTransformer;
        $this->descriptionsInAutomationTransformer = $descriptionsInAutomationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationAutomationInterface
    {
        $model = new DeviceConfigurationAutomation();

        $this->applyConditions($model, $data);
        $this->applyActions($model, $data);
        $this->applyDescriptions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(DeviceConfigurationAutomation $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListExcludedDeviceActionConfigEntry($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyConditions(DeviceConfigurationAutomation $model, array $data): void
    {
        if (!isset($data[self::KEY_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_CONDITIONS])) {
            return;
        }
        $model->setConditions($this->transformListExcludedDeviceConditionConfigEntry($data[self::KEY_CONDITIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDescriptions(DeviceConfigurationAutomation $model, array $data): void
    {
        if (!isset($data[self::KEY_DESCRIPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_DESCRIPTIONS])) {
            return;
        }
        $model->setDescriptions($this->descriptionsInAutomationTransformer->transform($data[self::KEY_DESCRIPTIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    private function transformListExcludedDeviceActionConfigEntry(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedDeviceActionConfigEntryInterface => $this->excludedDeviceActionConfigEntryTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedDeviceConditionConfigEntryInterface>
     */
    private function transformListExcludedDeviceConditionConfigEntry(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedDeviceConditionConfigEntryInterface => $this->excludedDeviceConditionConfigEntryTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
