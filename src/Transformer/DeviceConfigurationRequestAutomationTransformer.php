<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomation;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomationInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DeviceConfigurationRequestAutomationTransformer implements DeviceConfigurationRequestAutomationTransformerInterface
{
    private ExcludedDeviceActionConfigEntryTransformerInterface $excludedDeviceActionConfigEntryTransformer;
    private ExcludedDeviceConditionConfigEntryTransformerInterface $excludedDeviceConditionConfigEntryTransformer;

    public function __construct(ExcludedDeviceConditionConfigEntryTransformerInterface $excludedDeviceConditionConfigEntryTransformer, ExcludedDeviceActionConfigEntryTransformerInterface $excludedDeviceActionConfigEntryTransformer)
    {
        $this->excludedDeviceConditionConfigEntryTransformer = $excludedDeviceConditionConfigEntryTransformer;
        $this->excludedDeviceActionConfigEntryTransformer = $excludedDeviceActionConfigEntryTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationRequestAutomationInterface
    {
        $model = new DeviceConfigurationRequestAutomation();

        $this->applyConditions($model, $data);
        $this->applyActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(DeviceConfigurationRequestAutomation $model, array $data): void
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
    private function applyConditions(DeviceConfigurationRequestAutomation $model, array $data): void
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
