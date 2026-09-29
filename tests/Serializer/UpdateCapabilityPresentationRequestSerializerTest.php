<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateCapabilityPresentationRequest::class)]
#[CoversClass(UpdateCapabilityPresentationRequestSerializer::class)]
final class UpdateCapabilityPresentationRequestSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilitySerializer = self::createStub(DashboardForCapabilitySerializerInterface::class);
        $dashboardForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-dashboard-for-capability']);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemSerializer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemSerializer->method('serialize')->willReturn(['test-serialized-create-capability-presentation-request-detail-view-item']);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilitySerializer = self::createStub(AutomationForCapabilitySerializerInterface::class);
        $automationForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability']);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsSerializer = self::createStub(PresentationSettingsSerializerInterface::class);
        $presentationSettingsSerializer->method('serialize')->willReturn(['test-serialized-presentation-settings']);
        $model = new UpdateCapabilityPresentationRequest();

        $serializer = new UpdateCapabilityPresentationRequestSerializer($dashboardForCapabilitySerializer, $createCapabilityPresentationRequestDetailViewItemSerializer, $automationForCapabilitySerializer, $presentationSettingsSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilitySerializer = self::createStub(DashboardForCapabilitySerializerInterface::class);
        $dashboardForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-dashboard-for-capability']);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemSerializer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemSerializerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemSerializer->method('serialize')->willReturn(['test-serialized-create-capability-presentation-request-detail-view-item']);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilitySerializer = self::createStub(AutomationForCapabilitySerializerInterface::class);
        $automationForCapabilitySerializer->method('serialize')->willReturn(['test-serialized-automation-for-capability']);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsSerializer = self::createStub(PresentationSettingsSerializerInterface::class);
        $presentationSettingsSerializer->method('serialize')->willReturn(['test-serialized-presentation-settings']);
        $model = (new UpdateCapabilityPresentationRequest())
            ->setDashboard($dashboardForCapabilityModel)
            ->setDetailView([$createCapabilityPresentationRequestDetailViewItemModel])
            ->setAutomation($automationForCapabilityModel)
            ->setPresentationSettings($presentationSettingsModel);

        $serializer = new UpdateCapabilityPresentationRequestSerializer($dashboardForCapabilitySerializer, $createCapabilityPresentationRequestDetailViewItemSerializer, $automationForCapabilitySerializer, $presentationSettingsSerializer);

        self::assertSame(
            [
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_DASHBOARD => ['test-serialized-dashboard-for-capability'],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_DETAIL_VIEW => [['test-serialized-create-capability-presentation-request-detail-view-item']],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_AUTOMATION => ['test-serialized-automation-for-capability'],
                UpdateCapabilityPresentationRequestSerializerInterface::KEY_PRESENTATION_SETTINGS => ['test-serialized-presentation-settings'],
            ],
            $serializer->serialize($model)
        );
    }
}
