<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequest;
use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class CreateDeviceConfigRequestTransformer implements CreateDeviceConfigRequestTransformerInterface
{
    private DeviceConfigEntryForDetailViewTransformerInterface $deviceConfigEntryForDetailViewTransformer;
    private DeviceConfigurationDashboardTransformerInterface $deviceConfigurationDashboardTransformer;
    private DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer;
    private DeviceConfigurationRequestAutomationTransformerInterface $deviceConfigurationRequestAutomationTransformer;

    public function __construct(DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer, DeviceConfigurationDashboardTransformerInterface $deviceConfigurationDashboardTransformer, DeviceConfigEntryForDetailViewTransformerInterface $deviceConfigEntryForDetailViewTransformer, DeviceConfigurationRequestAutomationTransformerInterface $deviceConfigurationRequestAutomationTransformer)
    {
        $this->deviceConfigurationIconsItemTransformer = $deviceConfigurationIconsItemTransformer;
        $this->deviceConfigurationDashboardTransformer = $deviceConfigurationDashboardTransformer;
        $this->deviceConfigEntryForDetailViewTransformer = $deviceConfigEntryForDetailViewTransformer;
        $this->deviceConfigurationRequestAutomationTransformer = $deviceConfigurationRequestAutomationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateDeviceConfigRequestInterface
    {
        $model = new CreateDeviceConfigRequest();

        self::applyIconUrl($model, $data);
        $this->applyIcons($model, $data);
        $this->applyDashboard($model, $data);
        $this->applyDetailView($model, $data);
        $this->applyAutomation($model, $data);
        self::applyType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAutomation(CreateDeviceConfigRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_AUTOMATION])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTOMATION])) {
            return;
        }
        $model->setAutomation($this->deviceConfigurationRequestAutomationTransformer->transform($data[self::KEY_AUTOMATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDashboard(CreateDeviceConfigRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_DASHBOARD])) {
            return;
        }
        if (!is_array($data[self::KEY_DASHBOARD])) {
            return;
        }
        $model->setDashboard($this->deviceConfigurationDashboardTransformer->transform($data[self::KEY_DASHBOARD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetailView(CreateDeviceConfigRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        if (!is_array($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        $model->setDetailView($this->transformListDeviceConfigEntryForDetailView($data[self::KEY_DETAIL_VIEW]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIcons(CreateDeviceConfigRequest $model, array $data): void
    {
        if (!isset($data[self::KEY_ICONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ICONS])) {
            return;
        }
        $model->setIcons($this->transformListDeviceConfigurationIconsItem($data[self::KEY_ICONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(CreateDeviceConfigRequest $model, array $data): void
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
    private static function applyType(CreateDeviceConfigRequest $model, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $model->setType($data[self::KEY_TYPE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigEntryForDetailViewInterface>
     */
    private function transformListDeviceConfigEntryForDetailView(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigEntryForDetailViewInterface => $this->deviceConfigEntryForDetailViewTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationIconsItemInterface>
     */
    private function transformListDeviceConfigurationIconsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationIconsItemInterface => $this->deviceConfigurationIconsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
