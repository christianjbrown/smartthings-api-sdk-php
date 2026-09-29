<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequest;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDetailViewInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDashboardInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestAutomationInterface;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformer;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDetailViewTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDashboardTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationRequestAutomationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateDeviceConfigRequest::class)]
#[CoversClass(CreateDeviceConfigRequestTransformer::class)]
final class CreateDeviceConfigRequestTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $data = [
            CreateDeviceConfigRequestTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            CreateDeviceConfigRequestTransformerInterface::KEY_ICONS => [['test-nested']],
            CreateDeviceConfigRequestTransformerInterface::KEY_DASHBOARD => ['test-nested'],
            CreateDeviceConfigRequestTransformerInterface::KEY_DETAIL_VIEW => [['test-nested']],
            CreateDeviceConfigRequestTransformerInterface::KEY_AUTOMATION => ['test-nested'],
            CreateDeviceConfigRequestTransformerInterface::KEY_TYPE => 'test-type',
        ];

        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame([$deviceConfigurationIconsItemModel], $actual->getIcons());
        self::assertSame($deviceConfigurationDashboardModel, $actual->getDashboard());
        self::assertSame([$deviceConfigEntryForDetailViewModel], $actual->getDetailView());
        self::assertSame($deviceConfigurationRequestAutomationModel, $actual->getAutomation());
        self::assertSame('test-type', $actual->getType());
    }

    public function testTransformAutomation(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAutomation());
        self::assertNull($transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_AUTOMATION => 'test-not-array'])->getAutomation());
        self::assertSame($deviceConfigurationRequestAutomationModel, $transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_AUTOMATION => ['test-nested']])->getAutomation());
    }

    public function testTransformDashboard(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDashboard());
        self::assertNull($transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_DASHBOARD => 'test-not-array'])->getDashboard());
        self::assertSame($deviceConfigurationDashboardModel, $transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_DASHBOARD => ['test-nested']])->getDashboard());
    }

    public function testTransformDetailView(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDetailView());
        self::assertNull($transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_DETAIL_VIEW => 'test-not-array'])->getDetailView());
        self::assertSame([$deviceConfigEntryForDetailViewModel], $transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_DETAIL_VIEW => [['test-nested'], 'test-skipped']])->getDetailView());
    }

    public function testTransformIcons(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getIcons());
        self::assertNull($transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_ICONS => 'test-not-array'])->getIcons());
        self::assertSame([$deviceConfigurationIconsItemModel], $transformer->transform($base + [CreateDeviceConfigRequestTransformerInterface::KEY_ICONS => [['test-nested'], 'test-skipped']])->getIcons());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CreateDeviceConfigRequestTransformer(self::createStub(DeviceConfigurationIconsItemTransformerInterface::class), self::createStub(DeviceConfigurationDashboardTransformerInterface::class), self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class), self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[CreateDeviceConfigRequestTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[CreateDeviceConfigRequestTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[CreateDeviceConfigRequestTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[CreateDeviceConfigRequestTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceConfigurationIconsItemModel = self::createStub(DeviceConfigurationIconsItemInterface::class);
        $deviceConfigurationIconsItemTransformer = self::createStub(DeviceConfigurationIconsItemTransformerInterface::class);
        $deviceConfigurationIconsItemTransformer->method('transform')->willReturn($deviceConfigurationIconsItemModel);
        $deviceConfigurationDashboardModel = self::createStub(DeviceConfigurationDashboardInterface::class);
        $deviceConfigurationDashboardTransformer = self::createStub(DeviceConfigurationDashboardTransformerInterface::class);
        $deviceConfigurationDashboardTransformer->method('transform')->willReturn($deviceConfigurationDashboardModel);
        $deviceConfigEntryForDetailViewModel = self::createStub(DeviceConfigEntryForDetailViewInterface::class);
        $deviceConfigEntryForDetailViewTransformer = self::createStub(DeviceConfigEntryForDetailViewTransformerInterface::class);
        $deviceConfigEntryForDetailViewTransformer->method('transform')->willReturn($deviceConfigEntryForDetailViewModel);
        $deviceConfigurationRequestAutomationModel = self::createStub(DeviceConfigurationRequestAutomationInterface::class);
        $deviceConfigurationRequestAutomationTransformer = self::createStub(DeviceConfigurationRequestAutomationTransformerInterface::class);
        $deviceConfigurationRequestAutomationTransformer->method('transform')->willReturn($deviceConfigurationRequestAutomationModel);
        $transformer = new CreateDeviceConfigRequestTransformer($deviceConfigurationIconsItemTransformer, $deviceConfigurationDashboardTransformer, $deviceConfigEntryForDetailViewTransformer, $deviceConfigurationRequestAutomationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getIcons());
        self::assertNull($actual->getDashboard());
        self::assertNull($actual->getDetailView());
        self::assertNull($actual->getAutomation());
        self::assertNull($actual->getType());
    }
}
