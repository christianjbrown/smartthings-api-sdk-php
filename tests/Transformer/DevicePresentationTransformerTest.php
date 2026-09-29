<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AutomationInterface;
use ChristianBrown\SmartThings\Model\DashboardInterface;
use ChristianBrown\SmartThings\Model\DetailViewListItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DevicePresentation;
use ChristianBrown\SmartThings\Model\LanguageItemInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsForDevicePresentationInterface;
use ChristianBrown\SmartThings\Transformer\AutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DetailViewListItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfosItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LanguageItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PresentationSettingsForDevicePresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePresentation::class)]
#[CoversClass(DevicePresentationTransformer::class)]
final class DevicePresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $data = [
            DevicePresentationTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name',
            DevicePresentationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
            DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn',
            DevicePresentationTransformerInterface::KEY_VID => 'test-vid',
            DevicePresentationTransformerInterface::KEY_VERSION => 'test-version',
            DevicePresentationTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            DevicePresentationTransformerInterface::KEY_DESCRIPTION => 'test-description',
            DevicePresentationTransformerInterface::KEY_ICONS => [['test-nested']],
            DevicePresentationTransformerInterface::KEY_DASHBOARD => ['test-nested'],
            DevicePresentationTransformerInterface::KEY_DETAIL_VIEW => [['test-nested']],
            DevicePresentationTransformerInterface::KEY_AUTOMATION => ['test-nested'],
            DevicePresentationTransformerInterface::KEY_DP_INFO => [['test-nested']],
            DevicePresentationTransformerInterface::KEY_DP_INFOS => [['test-nested']],
            DevicePresentationTransformerInterface::KEY_LANGUAGE => [['test-nested']],
            DevicePresentationTransformerInterface::KEY_PRESENTATION_SETTINGS => ['test-nested'],
        ];

        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-manufacturer-name', $actual->getManufacturerName());
        self::assertSame('test-presentation-id', $actual->getPresentationId());
        self::assertSame('test-mnmn', $actual->getMnmn());
        self::assertSame('test-vid', $actual->getVid());
        self::assertSame('test-version', $actual->getVersion());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame([$deviceConfigurationIconsItemModel], $actual->getIcons());
        self::assertSame($dashboardModel, $actual->getDashboard());
        self::assertSame([$detailViewListItemModel], $actual->getDetailView());
        self::assertSame($automationModel, $actual->getAutomation());
        self::assertSame([$deviceConfigurationDpInfoItemModel], $actual->getDpInfo());
        self::assertSame([$deviceConfigurationDpInfosItemModel], $actual->getDpInfos());
        self::assertSame([$languageItemModel], $actual->getLanguage());
        self::assertSame($presentationSettingsForDevicePresentationModel, $actual->getPresentationSettings());
    }

    public function testTransformAutomation(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getAutomation());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_AUTOMATION => 'test-not-array'])->getAutomation());
        self::assertSame($automationModel, $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_AUTOMATION => ['test-nested']])->getAutomation());
    }

    public function testTransformDashboard(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDashboard());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DASHBOARD => 'test-not-array'])->getDashboard());
        self::assertSame($dashboardModel, $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DASHBOARD => ['test-nested']])->getDashboard());
    }

    public function testTransformDetailView(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDetailView());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DETAIL_VIEW => 'test-not-array'])->getDetailView());
        self::assertSame([$detailViewListItemModel], $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DETAIL_VIEW => [['test-nested'], 'test-skipped']])->getDetailView());
    }

    public function testTransformDpInfo(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDpInfo());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DP_INFO => 'test-not-array'])->getDpInfo());
        self::assertSame([$deviceConfigurationDpInfoItemModel], $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DP_INFO => [['test-nested'], 'test-skipped']])->getDpInfo());
    }

    public function testTransformDpInfos(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDpInfos());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DP_INFOS => 'test-not-array'])->getDpInfos());
        self::assertSame([$deviceConfigurationDpInfosItemModel], $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_DP_INFOS => [['test-nested'], 'test-skipped']])->getDpInfos());
    }

    public function testTransformIcons(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getIcons());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_ICONS => 'test-not-array'])->getIcons());
        self::assertSame([$deviceConfigurationIconsItemModel], $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_ICONS => [['test-nested'], 'test-skipped']])->getIcons());
    }

    public function testTransformLanguage(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getLanguage());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_LANGUAGE => 'test-not-array'])->getLanguage());
        self::assertSame([$languageItemModel], $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_LANGUAGE => [['test-nested'], 'test-skipped']])->getLanguage());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DevicePresentationTransformer(self::createStub(DeviceConfigurationIconsItemTransformerInterface::class), self::createStub(DashboardTransformerInterface::class), self::createStub(DetailViewListItemTransformerInterface::class), self::createStub(AutomationTransformerInterface::class), self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class), self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class), self::createStub(LanguageItemTransformerInterface::class), self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class));

        $actual = $transformer->transform([DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'manufacturerNameAbsent' => [[], 'getManufacturerName', null];
        yield 'manufacturerNameWrongType' => [[DevicePresentationTransformerInterface::KEY_MANUFACTURER_NAME => 42], 'getManufacturerName', null];
        yield 'manufacturerNameValid' => [[DevicePresentationTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'], 'getManufacturerName', 'test-manufacturer-name'];
        yield 'presentationIdAbsent' => [[], 'getPresentationId', null];
        yield 'presentationIdWrongType' => [[DevicePresentationTransformerInterface::KEY_PRESENTATION_ID => 42], 'getPresentationId', null];
        yield 'presentationIdValid' => [[DevicePresentationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id'], 'getPresentationId', 'test-presentation-id'];
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DevicePresentationTransformerInterface::KEY_VERSION => 42], 'getVersion', null];
        yield 'versionValid' => [[DevicePresentationTransformerInterface::KEY_VERSION => 'test-version'], 'getVersion', 'test-version'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[DevicePresentationTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[DevicePresentationTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[DevicePresentationTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[DevicePresentationTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformPresentationSettings(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);
        $base = [DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getPresentationSettings());
        self::assertNull($transformer->transform($base + [DevicePresentationTransformerInterface::KEY_PRESENTATION_SETTINGS => 'test-not-array'])->getPresentationSettings());
        self::assertSame($presentationSettingsForDevicePresentationModel, $transformer->transform($base + [DevicePresentationTransformerInterface::KEY_PRESENTATION_SETTINGS => ['test-nested']])->getPresentationSettings());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $dashboardModel = self::createStub(DashboardInterface::class);
        $dashboardTransformer = self::createStub(DashboardTransformerInterface::class);
        $dashboardTransformer->method('transform')->willReturn($dashboardModel);
        $detailViewListItemModel = self::createStub(DetailViewListItemInterface::class);
        $detailViewListItemTransformer = self::createStub(DetailViewListItemTransformerInterface::class);
        $detailViewListItemTransformer->method('transform')->willReturn($detailViewListItemModel);
        $automationModel = self::createStub(AutomationInterface::class);
        $automationTransformer = self::createStub(AutomationTransformerInterface::class);
        $automationTransformer->method('transform')->willReturn($automationModel);
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $languageItemModel = self::createStub(LanguageItemInterface::class);
        $languageItemTransformer = self::createStub(LanguageItemTransformerInterface::class);
        $languageItemTransformer->method('transform')->willReturn($languageItemModel);
        $presentationSettingsForDevicePresentationModel = self::createStub(PresentationSettingsForDevicePresentationInterface::class);
        $presentationSettingsForDevicePresentationTransformer = self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class);
        $presentationSettingsForDevicePresentationTransformer->method('transform')->willReturn($presentationSettingsForDevicePresentationModel);
        $transformer = new DevicePresentationTransformer($deviceConfigurationIconsItemTransformer, $dashboardTransformer, $detailViewListItemTransformer, $automationTransformer, $deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $languageItemTransformer, $presentationSettingsForDevicePresentationTransformer);

        $actual = $transformer->transform([DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 'test-vid']);

        self::assertNull($actual->getManufacturerName());
        self::assertNull($actual->getPresentationId());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getIcons());
        self::assertNull($actual->getDashboard());
        self::assertNull($actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getDpInfo());
        self::assertNull($actual->getDpInfos());
        self::assertNull($actual->getLanguage());
        self::assertNull($actual->getPresentationSettings());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DevicePresentationTransformer(self::createStub(DeviceConfigurationIconsItemTransformerInterface::class), self::createStub(DashboardTransformerInterface::class), self::createStub(DetailViewListItemTransformerInterface::class), self::createStub(AutomationTransformerInterface::class), self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class), self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class), self::createStub(LanguageItemTransformerInterface::class), self::createStub(PresentationSettingsForDevicePresentationTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'mnmnAbsent' => [[DevicePresentationTransformerInterface::KEY_VID => 'test-vid'], sprintf(DevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePresentationTransformerInterface::KEY_MNMN)];
        yield 'mnmnWrongType' => [[DevicePresentationTransformerInterface::KEY_VID => 'test-vid', DevicePresentationTransformerInterface::KEY_MNMN => 42], sprintf(DevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePresentationTransformerInterface::KEY_MNMN)];
        yield 'vidAbsent' => [[DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn'], sprintf(DevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePresentationTransformerInterface::KEY_VID)];
        yield 'vidWrongType' => [[DevicePresentationTransformerInterface::KEY_MNMN => 'test-mnmn', DevicePresentationTransformerInterface::KEY_VID => 42], sprintf(DevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePresentationTransformerInterface::KEY_VID)];
    }
}
