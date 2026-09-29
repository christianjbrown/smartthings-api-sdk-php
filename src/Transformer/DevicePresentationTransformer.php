<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DetailViewListItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DevicePresentation;
use ChristianBrown\SmartThings\Model\DevicePresentationInterface;
use ChristianBrown\SmartThings\Model\LanguageItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class DevicePresentationTransformer implements DevicePresentationTransformerInterface
{
    private AutomationTransformerInterface $automationTransformer;
    private DashboardTransformerInterface $dashboardTransformer;
    private DetailViewListItemTransformerInterface $detailViewListItemTransformer;
    private DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer;
    private DeviceConfigurationDpInfosItemTransformerInterface $deviceConfigurationDpInfosItemTransformer;
    private DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer;
    private LanguageItemTransformerInterface $languageItemTransformer;
    private PresentationSettingsForDevicePresentationTransformerInterface $presentationSettingsForDevicePresentationTransformer;

    public function __construct(DeviceConfigurationIconsItemTransformerInterface $deviceConfigurationIconsItemTransformer, DashboardTransformerInterface $dashboardTransformer, DetailViewListItemTransformerInterface $detailViewListItemTransformer, AutomationTransformerInterface $automationTransformer, DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer, DeviceConfigurationDpInfosItemTransformerInterface $deviceConfigurationDpInfosItemTransformer, LanguageItemTransformerInterface $languageItemTransformer, PresentationSettingsForDevicePresentationTransformerInterface $presentationSettingsForDevicePresentationTransformer)
    {
        $this->deviceConfigurationIconsItemTransformer = $deviceConfigurationIconsItemTransformer;
        $this->dashboardTransformer = $dashboardTransformer;
        $this->detailViewListItemTransformer = $detailViewListItemTransformer;
        $this->automationTransformer = $automationTransformer;
        $this->deviceConfigurationDpInfoItemTransformer = $deviceConfigurationDpInfoItemTransformer;
        $this->deviceConfigurationDpInfosItemTransformer = $deviceConfigurationDpInfosItemTransformer;
        $this->languageItemTransformer = $languageItemTransformer;
        $this->presentationSettingsForDevicePresentationTransformer = $presentationSettingsForDevicePresentationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DevicePresentationInterface
    {
        $model = new DevicePresentation(self::requireMnmn($data), self::requireVid($data));

        self::applyManufacturerName($model, $data);
        self::applyPresentationId($model, $data);
        self::applyVersion($model, $data);
        self::applyIconUrl($model, $data);
        self::applyDescription($model, $data);
        $this->applyIcons($model, $data);
        $this->applyDashboard($model, $data);
        $this->applyDetailView($model, $data);
        $this->applyAutomation($model, $data);
        $this->applyDpInfo($model, $data);
        $this->applyDpInfos($model, $data);
        $this->applyLanguage($model, $data);
        $this->applyPresentationSettings($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAutomation(DevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_AUTOMATION])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTOMATION])) {
            return;
        }
        $model->setAutomation($this->automationTransformer->transform($data[self::KEY_AUTOMATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDashboard(DevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_DASHBOARD])) {
            return;
        }
        if (!is_array($data[self::KEY_DASHBOARD])) {
            return;
        }
        $model->setDashboard($this->dashboardTransformer->transform($data[self::KEY_DASHBOARD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(DevicePresentation $model, array $data): void
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
    private function applyDetailView(DevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        if (!is_array($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        $model->setDetailView($this->transformListDetailViewListItem($data[self::KEY_DETAIL_VIEW]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDpInfo(DevicePresentation $model, array $data): void
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
    private function applyDpInfos(DevicePresentation $model, array $data): void
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
    private function applyIcons(DevicePresentation $model, array $data): void
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
    private static function applyIconUrl(DevicePresentation $model, array $data): void
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
    private function applyLanguage(DevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_LANGUAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_LANGUAGE])) {
            return;
        }
        $model->setLanguage($this->transformListLanguageItem($data[self::KEY_LANGUAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerName(DevicePresentation $model, array $data): void
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
    private static function applyPresentationId(DevicePresentation $model, array $data): void
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
    private function applyPresentationSettings(DevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_PRESENTATION_SETTINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_PRESENTATION_SETTINGS])) {
            return;
        }
        $model->setPresentationSettings($this->presentationSettingsForDevicePresentationTransformer->transform($data[self::KEY_PRESENTATION_SETTINGS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(DevicePresentation $model, array $data): void
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
     * @return array<int, DetailViewListItemInterface>
     */
    private function transformListDetailViewListItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DetailViewListItemInterface => $this->detailViewListItemTransformer->transform($item), array_filter($data, is_array(...))));
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

    /**
     * @param mixed[] $data
     *
     * @return array<int, LanguageItemInterface>
     */
    private function transformListLanguageItem(array $data): array
    {
        return array_values(array_map(fn (array $item): LanguageItemInterface => $this->languageItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
