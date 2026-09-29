<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfiguration;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class DeviceConfigurationTransformer implements DeviceConfigurationTransformerInterface
{
    private DeviceConfigEntryForDetailViewTransformerInterface $deviceConfigEntryForDetailViewTransformer;
    private DeviceConfigurationAutomationTransformerInterface $deviceConfigurationAutomationTransformer;
    private DeviceConfigurationDashboardTransformerInterface $deviceConfigurationDashboardTransformer;
    private DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer;
    private DeviceConfigurationDpInfosItemTransformerInterface $deviceConfigurationDpInfosItemTransformer;
    private DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer;

    public function __construct(DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer, DeviceConfigurationDpInfosItemTransformerInterface $deviceConfigurationDpInfosItemTransformer, DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer, DeviceConfigurationDashboardTransformerInterface $deviceConfigurationDashboardTransformer, DeviceConfigEntryForDetailViewTransformerInterface $deviceConfigEntryForDetailViewTransformer, DeviceConfigurationAutomationTransformerInterface $deviceConfigurationAutomationTransformer)
    {
        $this->deviceConfigurationDpInfoItemTransformer = $deviceConfigurationDpInfoItemTransformer;
        $this->deviceConfigurationDpInfosItemTransformer = $deviceConfigurationDpInfosItemTransformer;
        $this->deviceConfigurationIconsItemTransformer = $deviceConfigurationIconsItemTransformer;
        $this->deviceConfigurationDashboardTransformer = $deviceConfigurationDashboardTransformer;
        $this->deviceConfigEntryForDetailViewTransformer = $deviceConfigEntryForDetailViewTransformer;
        $this->deviceConfigurationAutomationTransformer = $deviceConfigurationAutomationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationInterface
    {
        $model = new DeviceConfiguration(self::requireMnmn($data), self::requireVid($data));

        self::applyVersion($model, $data);
        self::applyDescription($model, $data);
        self::applyType($model, $data);
        $this->applyDpInfo($model, $data);
        $this->applyDpInfos($model, $data);
        self::applyIconUrl($model, $data);
        $this->applyIcons($model, $data);
        $this->applyDashboard($model, $data);
        $this->applyDetailView($model, $data);
        $this->applyAutomation($model, $data);
        self::applyPresentationId($model, $data);
        self::applyManufacturerName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAutomation(DeviceConfiguration $model, array $data): void
    {
        if (!isset($data[self::KEY_AUTOMATION])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTOMATION])) {
            return;
        }
        $model->setAutomation($this->deviceConfigurationAutomationTransformer->transform($data[self::KEY_AUTOMATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDashboard(DeviceConfiguration $model, array $data): void
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
    private static function applyDescription(DeviceConfiguration $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetailView(DeviceConfiguration $model, array $data): void
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
    private function applyDpInfo(DeviceConfiguration $model, array $data): void
    {
        if (!isset($data[self::KEY_DP_INFO])) {
            return;
        }
        if (!is_array($data[self::KEY_DP_INFO])) {
            return;
        }
        $model->setDpInfo($this->transformListDeviceConfigurationDpInfoItem($data[self::KEY_DP_INFO]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDpInfos(DeviceConfiguration $model, array $data): void
    {
        if (!isset($data[self::KEY_DP_INFOS])) {
            return;
        }
        if (!is_array($data[self::KEY_DP_INFOS])) {
            return;
        }
        $model->setDpInfos($this->transformListDeviceConfigurationDpInfosItem($data[self::KEY_DP_INFOS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIcons(DeviceConfiguration $model, array $data): void
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
    private static function applyIconUrl(DeviceConfiguration $model, array $data): void
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
    private static function applyManufacturerName(DeviceConfiguration $model, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        $model->setManufacturerName($data[self::KEY_MANUFACTURER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPresentationId(DeviceConfiguration $model, array $data): void
    {
        if (empty($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        $model->setPresentationId($data[self::KEY_PRESENTATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(DeviceConfiguration $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(DeviceConfiguration $model, array $data): void
    {
        if (empty($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireMnmn(array $data): string
    {
        if (empty($data[self::KEY_MNMN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MNMN));
        }
        if (!is_string($data[self::KEY_MNMN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MNMN));
        }

        return $data[self::KEY_MNMN];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireVid(array $data): string
    {
        if (empty($data[self::KEY_VID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VID));
        }
        if (!is_string($data[self::KEY_VID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VID));
        }

        return $data[self::KEY_VID];
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
     * @return array<int, DeviceConfigurationDpInfoItemInterface>
     */
    private function transformListDeviceConfigurationDpInfoItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationDpInfoItemInterface => $this->deviceConfigurationDpInfoItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationDpInfosItemInterface>
     */
    private function transformListDeviceConfigurationDpInfosItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationDpInfosItemInterface => $this->deviceConfigurationDpInfosItemTransformer->transform($item), array_filter($data, is_array(...))));
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
