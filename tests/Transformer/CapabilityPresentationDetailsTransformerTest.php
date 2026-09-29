<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityPresentationDetails;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Transformer\AutomationForCapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CreateCapabilityPresentationRequestDetailViewItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DashboardForCapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityPresentationDetails::class)]
#[CoversClass(CapabilityPresentationDetailsTransformer::class)]
final class CapabilityPresentationDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $data = [
            CapabilityPresentationDetailsTransformerInterface::KEY_DASHBOARD => ['test-nested'],
            CapabilityPresentationDetailsTransformerInterface::KEY_DETAIL_VIEW => [['test-nested']],
            CapabilityPresentationDetailsTransformerInterface::KEY_AUTOMATION => ['test-nested'],
            CapabilityPresentationDetailsTransformerInterface::KEY_PRESENTATION_SETTINGS => ['test-nested'],
        ];

        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($dashboardForCapabilityModel, $actual->getDashboard());
        self::assertSame([$createCapabilityPresentationRequestDetailViewItemModel], $actual->getDetailView());
        self::assertSame($automationForCapabilityModel, $actual->getAutomation());
        self::assertSame($presentationSettingsModel, $actual->getPresentationSettings());
    }

    public function testTransformAutomation(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAutomation());
        self::assertNull($transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_AUTOMATION => 'test-not-array'])->getAutomation());
        self::assertSame($automationForCapabilityModel, $transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_AUTOMATION => ['test-nested']])->getAutomation());
    }

    public function testTransformDashboard(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDashboard());
        self::assertNull($transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_DASHBOARD => 'test-not-array'])->getDashboard());
        self::assertSame($dashboardForCapabilityModel, $transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_DASHBOARD => ['test-nested']])->getDashboard());
    }

    public function testTransformDetailView(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDetailView());
        self::assertNull($transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_DETAIL_VIEW => 'test-not-array'])->getDetailView());
        self::assertSame([$createCapabilityPresentationRequestDetailViewItemModel], $transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_DETAIL_VIEW => [['test-nested'], 'test-skipped']])->getDetailView());
    }

    public function testTransformPresentationSettings(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getPresentationSettings());
        self::assertNull($transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_PRESENTATION_SETTINGS => 'test-not-array'])->getPresentationSettings());
        self::assertSame($presentationSettingsModel, $transformer->transform($base + [CapabilityPresentationDetailsTransformerInterface::KEY_PRESENTATION_SETTINGS => ['test-nested']])->getPresentationSettings());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $dashboardForCapabilityModel = self::createStub(DashboardForCapabilityInterface::class);
        $dashboardForCapabilityTransformer = self::createStub(DashboardForCapabilityTransformerInterface::class);
        $dashboardForCapabilityTransformer->method('transform')->willReturn($dashboardForCapabilityModel);
        $createCapabilityPresentationRequestDetailViewItemModel = self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer = self::createStub(CreateCapabilityPresentationRequestDetailViewItemTransformerInterface::class);
        $createCapabilityPresentationRequestDetailViewItemTransformer->method('transform')->willReturn($createCapabilityPresentationRequestDetailViewItemModel);
        $automationForCapabilityModel = self::createStub(AutomationForCapabilityInterface::class);
        $automationForCapabilityTransformer = self::createStub(AutomationForCapabilityTransformerInterface::class);
        $automationForCapabilityTransformer->method('transform')->willReturn($automationForCapabilityModel);
        $presentationSettingsModel = self::createStub(PresentationSettingsInterface::class);
        $presentationSettingsTransformer = self::createStub(PresentationSettingsTransformerInterface::class);
        $presentationSettingsTransformer->method('transform')->willReturn($presentationSettingsModel);
        $transformer = new CapabilityPresentationDetailsTransformer($dashboardForCapabilityTransformer, $createCapabilityPresentationRequestDetailViewItemTransformer, $automationForCapabilityTransformer, $presentationSettingsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDashboard());
        self::assertNull($actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getPresentationSettings());
    }
}
