<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityPresentation;
use ChristianBrown\SmartThings\Model\CapabilityPresentationDetailsInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;
use ChristianBrown\SmartThings\Model\DashboardForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityPresentation::class)]
#[CoversClass(CapabilityPresentationTransformer::class)]
final class CapabilityPresentationTransformerExtendedTest extends TestCase
{
    public function testTransformExtendedNestedFields(): void
    {
        $dashboard = self::createStub(DashboardForCapabilityInterface::class);
        $detailView = [self::createStub(CreateCapabilityPresentationRequestDetailViewItemInterface::class)];
        $automation = self::createStub(AutomationForCapabilityInterface::class);
        $presentationSettings = self::createStub(PresentationSettingsInterface::class);
        $details = self::createStub(CapabilityPresentationDetailsInterface::class);
        $details->method('getDashboard')->willReturn($dashboard);
        $details->method('getDetailView')->willReturn($detailView);
        $details->method('getAutomation')->willReturn($automation);
        $details->method('getPresentationSettings')->willReturn($presentationSettings);

        $data = [CapabilityPresentationTransformerInterface::KEY_ID => 'test-id'] + [CapabilityPresentationTransformerInterface::KEY_DASHBOARD => []];
        $containerTransformer = self::createMock(CapabilityPresentationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new CapabilityPresentationTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($dashboard, $actual->getDashboard());
        self::assertSame($detailView, $actual->getDetailView());
        self::assertSame($automation, $actual->getAutomation());
        self::assertSame($presentationSettings, $actual->getPresentationSettings());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(CapabilityPresentationDetailsInterface::class);
        $containerTransformer = self::createStub(CapabilityPresentationDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new CapabilityPresentationTransformer($containerTransformer);

        $actual = $transformer->transform([CapabilityPresentationTransformerInterface::KEY_ID => 'test-id'] + [CapabilityPresentationTransformerInterface::KEY_DASHBOARD => []]);

        self::assertNull($actual->getDashboard());
        self::assertSame([], $actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getPresentationSettings());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(CapabilityPresentationDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new CapabilityPresentationTransformer($containerTransformer);

        $actual = $transformer->transform([CapabilityPresentationTransformerInterface::KEY_ID => 'test-id']);

        self::assertNull($actual->getDashboard());
        self::assertSame([], $actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getPresentationSettings());
    }
}
