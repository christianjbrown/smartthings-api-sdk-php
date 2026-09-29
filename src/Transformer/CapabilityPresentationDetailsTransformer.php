<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityPresentationDetails;
use ChristianBrown\SmartThings\Model\CapabilityPresentationDetailsInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class CapabilityPresentationDetailsTransformer implements CapabilityPresentationDetailsTransformerInterface
{
    private AutomationForCapabilityTransformerInterface $automationForCapabilityTransformer;
    private CreateCapabilityPresentationRequestDetailViewItemTransformerInterface $createCapabilityPresentationRequestDetailViewItemTransformer;
    private DashboardForCapabilityTransformerInterface $dashboardForCapabilityTransformer;
    private PresentationSettingsTransformerInterface $presentationSettingsTransformer;

    public function __construct(DashboardForCapabilityTransformerInterface $dashboardForCapabilityTransformer, CreateCapabilityPresentationRequestDetailViewItemTransformerInterface $createCapabilityPresentationRequestDetailViewItemTransformer, AutomationForCapabilityTransformerInterface $automationForCapabilityTransformer, PresentationSettingsTransformerInterface $presentationSettingsTransformer)
    {
        $this->dashboardForCapabilityTransformer = $dashboardForCapabilityTransformer;
        $this->createCapabilityPresentationRequestDetailViewItemTransformer = $createCapabilityPresentationRequestDetailViewItemTransformer;
        $this->automationForCapabilityTransformer = $automationForCapabilityTransformer;
        $this->presentationSettingsTransformer = $presentationSettingsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityPresentationDetailsInterface
    {
        $model = new CapabilityPresentationDetails();

        $this->applyDashboard($model, $data);
        $this->applyDetailView($model, $data);
        $this->applyAutomation($model, $data);
        $this->applyPresentationSettings($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAutomation(CapabilityPresentationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_AUTOMATION])) {
            return;
        }
        if (!is_array($data[self::KEY_AUTOMATION])) {
            return;
        }
        $model->setAutomation($this->automationForCapabilityTransformer->transform($data[self::KEY_AUTOMATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDashboard(CapabilityPresentationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DASHBOARD])) {
            return;
        }
        if (!is_array($data[self::KEY_DASHBOARD])) {
            return;
        }
        $model->setDashboard($this->dashboardForCapabilityTransformer->transform($data[self::KEY_DASHBOARD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetailView(CapabilityPresentationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        if (!is_array($data[self::KEY_DETAIL_VIEW])) {
            return;
        }
        $model->setDetailView($this->transformListCreateCapabilityPresentationRequestDetailViewItem($data[self::KEY_DETAIL_VIEW]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPresentationSettings(CapabilityPresentationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PRESENTATION_SETTINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_PRESENTATION_SETTINGS])) {
            return;
        }
        $model->setPresentationSettings($this->presentationSettingsTransformer->transform($data[self::KEY_PRESENTATION_SETTINGS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CreateCapabilityPresentationRequestDetailViewItemInterface>
     */
    private function transformListCreateCapabilityPresentationRequestDetailViewItem(array $data): array
    {
        return array_values(array_map(fn (array $item): CreateCapabilityPresentationRequestDetailViewItemInterface => $this->createCapabilityPresentationRequestDetailViewItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
