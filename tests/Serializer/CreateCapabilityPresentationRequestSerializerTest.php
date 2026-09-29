<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Serializer\AutomationForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestDetailViewItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DashboardForCapabilitySerializerInterface;
use ChristianBrown\SmartThings\Serializer\PresentationSettingsSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateCapabilityPresentationRequest::class)]
#[CoversClass(CreateCapabilityPresentationRequestSerializer::class)]
final class CreateCapabilityPresentationRequestSerializerTest extends TestCase
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
        $model = new CreateCapabilityPresentationRequest('test-id', 7);

        $serializer = new CreateCapabilityPresentationRequestSerializer($dashboardForCapabilitySerializer, $createCapabilityPresentationRequestDetailViewItemSerializer, $automationForCapabilitySerializer, $presentationSettingsSerializer);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestSerializerInterface::KEY_ID => 'test-id',
                CreateCapabilityPresentationRequestSerializerInterface::KEY_VERSION => 7,
            ],
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
        $model = (new CreateCapabilityPresentationRequest('test-id', 7))
            ->setDashboard($dashboardForCapabilityModel)
            ->setDetailView([$createCapabilityPresentationRequestDetailViewItemModel])
            ->setAutomation($automationForCapabilityModel)
            ->setPresentationSettings($presentationSettingsModel);

        $serializer = new CreateCapabilityPresentationRequestSerializer($dashboardForCapabilitySerializer, $createCapabilityPresentationRequestDetailViewItemSerializer, $automationForCapabilitySerializer, $presentationSettingsSerializer);

        self::assertSame(
            [
                CreateCapabilityPresentationRequestSerializerInterface::KEY_DASHBOARD => ['test-serialized-dashboard-for-capability'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_DETAIL_VIEW => [['test-serialized-create-capability-presentation-request-detail-view-item']],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_AUTOMATION => ['test-serialized-automation-for-capability'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_PRESENTATION_SETTINGS => ['test-serialized-presentation-settings'],
                CreateCapabilityPresentationRequestSerializerInterface::KEY_ID => 'test-id',
                CreateCapabilityPresentationRequestSerializerInterface::KEY_VERSION => 7,
            ],
            $serializer->serialize($model)
        );
    }
}
