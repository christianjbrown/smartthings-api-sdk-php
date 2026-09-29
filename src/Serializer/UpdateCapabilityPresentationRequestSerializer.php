<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequestInterface;

use function array_filter;
use function array_map;

final class UpdateCapabilityPresentationRequestSerializer implements UpdateCapabilityPresentationRequestSerializerInterface
{
    private AutomationForCapabilitySerializerInterface $automationForCapabilitySerializer;
    private CreateCapabilityPresentationRequestDetailViewItemSerializerInterface $createCapabilityPresentationRequestDetailViewItemSerializer;
    private DashboardForCapabilitySerializerInterface $dashboardForCapabilitySerializer;
    private PresentationSettingsSerializerInterface $presentationSettingsSerializer;

    public function __construct(DashboardForCapabilitySerializerInterface $dashboardForCapabilitySerializer, CreateCapabilityPresentationRequestDetailViewItemSerializerInterface $createCapabilityPresentationRequestDetailViewItemSerializer, AutomationForCapabilitySerializerInterface $automationForCapabilitySerializer, PresentationSettingsSerializerInterface $presentationSettingsSerializer)
    {
        $this->dashboardForCapabilitySerializer = $dashboardForCapabilitySerializer;
        $this->createCapabilityPresentationRequestDetailViewItemSerializer = $createCapabilityPresentationRequestDetailViewItemSerializer;
        $this->automationForCapabilitySerializer = $automationForCapabilitySerializer;
        $this->presentationSettingsSerializer = $presentationSettingsSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(UpdateCapabilityPresentationRequestInterface $model): array
    {
        $serialized = [
            self::KEY_DASHBOARD => $this->serializeOptionalDashboard($model->getDashboard()),
            self::KEY_DETAIL_VIEW => $this->serializeDetailView($model->getDetailView()),
            self::KEY_AUTOMATION => $this->serializeOptionalAutomation($model->getAutomation()),
            self::KEY_PRESENTATION_SETTINGS => $this->serializeOptionalPresentationSettings($model->getPresentationSettings()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, CreateCapabilityPresentationRequestDetailViewItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeDetailView(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (CreateCapabilityPresentationRequestDetailViewItemInterface $item): array => $this->createCapabilityPresentationRequestDetailViewItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalAutomation(?AutomationForCapabilityInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->automationForCapabilitySerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDashboard(?DashboardForCapabilityInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->dashboardForCapabilitySerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPresentationSettings(?PresentationSettingsInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->presentationSettingsSerializer->serialize($value);
    }
}
