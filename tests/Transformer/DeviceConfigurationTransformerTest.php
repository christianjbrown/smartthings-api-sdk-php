<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfiguration;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDetailViewTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationAutomationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfosItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceConfiguration::class)]
#[CoversClass(DeviceConfigurationTransformer::class)]
final class DeviceConfigurationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $data = [
            DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn',
            DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid',
            DeviceConfigurationTransformerInterface::KEY_VERSION => 'test-version',
            DeviceConfigurationTransformerInterface::KEY_DESCRIPTION => 'test-description',
            DeviceConfigurationTransformerInterface::KEY_TYPE => 'test-type',
            DeviceConfigurationTransformerInterface::KEY_DP_INFO => [['test-nested']],
            DeviceConfigurationTransformerInterface::KEY_DP_INFOS => [['test-nested']],
            DeviceConfigurationTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            DeviceConfigurationTransformerInterface::KEY_ICONS => [['test-nested']],
            DeviceConfigurationTransformerInterface::KEY_DASHBOARD => ['test-nested'],
            DeviceConfigurationTransformerInterface::KEY_DETAIL_VIEW => [['test-nested']],
            DeviceConfigurationTransformerInterface::KEY_AUTOMATION => ['test-nested'],
            DeviceConfigurationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
            DeviceConfigurationTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name',
        ];

        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-mnmn', $actual->getMnmn());
        self::assertSame('test-vid', $actual->getVid());
        self::assertSame('test-version', $actual->getVersion());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame('test-type', $actual->getType());
        self::assertSame([$deviceConfigurationDpInfoItemModel], $actual->getDpInfo());
        self::assertSame([$deviceConfigurationDpInfosItemModel], $actual->getDpInfos());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame([$deviceConfigurationIconsItemModel], $actual->getIcons());
        self::assertSame($deviceConfigurationDashboardModel, $actual->getDashboard());
        self::assertSame([$deviceConfigEntryForDetailViewModel], $actual->getDetailView());
        self::assertSame($deviceConfigurationAutomationModel, $actual->getAutomation());
        self::assertSame('test-presentation-id', $actual->getPresentationId());
        self::assertSame('test-manufacturer-name', $actual->getManufacturerName());
    }

    public function testTransformAutomation(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getAutomation());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_AUTOMATION => 'test-not-array'])->getAutomation());
        self::assertSame($deviceConfigurationAutomationModel, $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_AUTOMATION => ['test-nested']])->getAutomation());
    }

    public function testTransformDashboard(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDashboard());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DASHBOARD => 'test-not-array'])->getDashboard());
        self::assertSame($deviceConfigurationDashboardModel, $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DASHBOARD => ['test-nested']])->getDashboard());
    }

    public function testTransformDetailView(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDetailView());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DETAIL_VIEW => 'test-not-array'])->getDetailView());
        self::assertSame([$deviceConfigEntryForDetailViewModel], $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DETAIL_VIEW => [['test-nested'], 'test-skipped']])->getDetailView());
    }

    public function testTransformDpInfo(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDpInfo());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DP_INFO => 'test-not-array'])->getDpInfo());
        self::assertSame([$deviceConfigurationDpInfoItemModel], $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DP_INFO => [['test-nested'], 'test-skipped']])->getDpInfo());
    }

    public function testTransformDpInfos(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getDpInfos());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DP_INFOS => 'test-not-array'])->getDpInfos());
        self::assertSame([$deviceConfigurationDpInfosItemModel], $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_DP_INFOS => [['test-nested'], 'test-skipped']])->getDpInfos());
    }

    public function testTransformIcons(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);
        $base = [DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'];

        self::assertNull($transformer->transform($base)->getIcons());
        self::assertNull($transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_ICONS => 'test-not-array'])->getIcons());
        self::assertSame([$deviceConfigurationIconsItemModel], $transformer->transform($base + [DeviceConfigurationTransformerInterface::KEY_ICONS => [['test-nested'], 'test-skipped']])->getIcons());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceConfigurationTransformer(self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class), self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class), self::createStub(DeviceConfigurationIconsItemTransformerInterface::class), self::createStub(DeviceConfigurationDashboardTransformerInterface::class), self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class), self::createStub(DeviceConfigurationAutomationTransformerInterface::class));

        $actual = $transformer->transform([DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[DeviceConfigurationTransformerInterface::KEY_VERSION => 42], 'getVersion', null];
        yield 'versionValid' => [[DeviceConfigurationTransformerInterface::KEY_VERSION => 'test-version'], 'getVersion', 'test-version'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[DeviceConfigurationTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[DeviceConfigurationTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[DeviceConfigurationTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[DeviceConfigurationTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[DeviceConfigurationTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[DeviceConfigurationTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'presentationIdAbsent' => [[], 'getPresentationId', null];
        yield 'presentationIdWrongType' => [[DeviceConfigurationTransformerInterface::KEY_PRESENTATION_ID => 42], 'getPresentationId', null];
        yield 'presentationIdValid' => [[DeviceConfigurationTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id'], 'getPresentationId', 'test-presentation-id'];
        yield 'manufacturerNameAbsent' => [[], 'getManufacturerName', null];
        yield 'manufacturerNameWrongType' => [[DeviceConfigurationTransformerInterface::KEY_MANUFACTURER_NAME => 42], 'getManufacturerName', null];
        yield 'manufacturerNameValid' => [[DeviceConfigurationTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'], 'getManufacturerName', 'test-manufacturer-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigurationDpInfoItemModel = self::createStub(DeviceConfigurationDpInfoItemInterface::class);
        $deviceConfigurationDpInfoItemTransformer = self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class);
        $deviceConfigurationDpInfoItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfoItemModel);
        $deviceConfigurationDpInfosItemModel = self::createStub(DeviceConfigurationDpInfosItemInterface::class);
        $deviceConfigurationDpInfosItemTransformer = self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class);
        $deviceConfigurationDpInfosItemTransformer->method('transform')->willReturn($deviceConfigurationDpInfosItemModel);
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationAutomationModel = self::createStub(DeviceConfigurationAutomationInterface::class);
        $deviceConfigurationAutomationTransformer = self::createStub(DeviceConfigurationAutomationTransformerInterface::class);
        $deviceConfigurationAutomationTransformer->method('transform')->willReturn($deviceConfigurationAutomationModel);
        $transformer = new DeviceConfigurationTransformer($deviceConfigurationDpInfoItemTransformer, $deviceConfigurationDpInfosItemTransformer, $deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationAutomationTransformer);

        $actual = $transformer->transform([DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getType());
        self::assertNull($actual->getDpInfo());
        self::assertNull($actual->getDpInfos());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getIcons());
        self::assertNull($actual->getDashboard());
        self::assertNull($actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getPresentationId());
        self::assertNull($actual->getManufacturerName());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationTransformer(self::createStub(DeviceConfigurationDpInfoItemTransformerInterface::class), self::createStub(DeviceConfigurationDpInfosItemTransformerInterface::class), self::createStub(DeviceConfigurationIconsItemTransformerInterface::class), self::createStub(DeviceConfigurationDashboardTransformerInterface::class), self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class), self::createStub(DeviceConfigurationAutomationTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'mnmnAbsent' => [[DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid'], sprintf(DeviceConfigurationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationTransformerInterface::KEY_MNMN)];
        yield 'mnmnWrongType' => [[DeviceConfigurationTransformerInterface::KEY_VID => 'test-vid', DeviceConfigurationTransformerInterface::KEY_MNMN => 42], sprintf(DeviceConfigurationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationTransformerInterface::KEY_MNMN)];
        yield 'vidAbsent' => [[DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn'], sprintf(DeviceConfigurationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationTransformerInterface::KEY_VID)];
        yield 'vidWrongType' => [[DeviceConfigurationTransformerInterface::KEY_MNMN => 'test-mnmn', DeviceConfigurationTransformerInterface::KEY_VID => 42], sprintf(DeviceConfigurationTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationTransformerInterface::KEY_VID)];
    }
}
