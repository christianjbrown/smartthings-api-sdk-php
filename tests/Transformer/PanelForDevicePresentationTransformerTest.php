<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentation;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationItemsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\PanelForDevicePresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PanelForDevicePresentation::class)]
#[CoversClass(PanelForDevicePresentationTransformer::class)]
final class PanelForDevicePresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $panelForDevicePresentationItemsItemModel = self::createStub(PanelForDevicePresentationItemsItemInterface::class);
        $panelForDevicePresentationItemsItemTransformer = self::createStub(PanelForDevicePresentationItemsItemTransformerInterface::class);
        $panelForDevicePresentationItemsItemTransformer->method('transform')->willReturn($panelForDevicePresentationItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            PanelForDevicePresentationTransformerInterface::KEY_ITEMS => [['test-nested']],
            PanelForDevicePresentationTransformerInterface::KEY_OPERATOR => 'test-operator',
            PanelForDevicePresentationTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested']],
            PanelForDevicePresentationTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true,
        ];

        $transformer = new PanelForDevicePresentationTransformer($panelForDevicePresentationItemsItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$panelForDevicePresentationItemsItemModel], $actual->getItems());
        self::assertSame('test-operator', $actual->getOperator());
        self::assertSame([$visibleConditionModel], $actual->getVisibleConditions());
        self::assertTrue($actual->getHideDashboardActions());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PanelForDevicePresentationTransformer(self::createStub(PanelForDevicePresentationItemsItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform([PanelForDevicePresentationTransformerInterface::KEY_ITEMS => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'operatorAbsent' => [[], 'getOperator', null];
        yield 'operatorWrongType' => [[PanelForDevicePresentationTransformerInterface::KEY_OPERATOR => 42], 'getOperator', null];
        yield 'operatorValid' => [[PanelForDevicePresentationTransformerInterface::KEY_OPERATOR => 'test-operator'], 'getOperator', 'test-operator'];
        yield 'hideDashboardActionsAbsent' => [[], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsWrongType' => [[PanelForDevicePresentationTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => 'not-bool'], 'getHideDashboardActions', null];
        yield 'hideDashboardActionsValid' => [[PanelForDevicePresentationTransformerInterface::KEY_HIDE_DASHBOARD_ACTIONS => true], 'getHideDashboardActions', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $panelForDevicePresentationItemsItemModel = self::createStub(PanelForDevicePresentationItemsItemInterface::class);
        $panelForDevicePresentationItemsItemTransformer = self::createStub(PanelForDevicePresentationItemsItemTransformerInterface::class);
        $panelForDevicePresentationItemsItemTransformer->method('transform')->willReturn($panelForDevicePresentationItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationTransformer($panelForDevicePresentationItemsItemTransformer, $visibleConditionTransformer);

        $actual = $transformer->transform([PanelForDevicePresentationTransformerInterface::KEY_ITEMS => ['test-nested']]);

        self::assertNull($actual->getOperator());
        self::assertNull($actual->getVisibleConditions());
        self::assertNull($actual->getHideDashboardActions());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PanelForDevicePresentationTransformer(self::createStub(PanelForDevicePresentationItemsItemTransformerInterface::class), self::createStub(VisibleConditionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'itemsAbsent' => [[], sprintf(PanelForDevicePresentationTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PanelForDevicePresentationTransformerInterface::KEY_ITEMS)];
        yield 'itemsWrongType' => [[PanelForDevicePresentationTransformerInterface::KEY_ITEMS => 'not-array'], sprintf(PanelForDevicePresentationTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PanelForDevicePresentationTransformerInterface::KEY_ITEMS)];
    }

    public function testTransformVisibleConditions(): void
    {
        $panelForDevicePresentationItemsItemModel = self::createStub(PanelForDevicePresentationItemsItemInterface::class);
        $panelForDevicePresentationItemsItemTransformer = self::createStub(PanelForDevicePresentationItemsItemTransformerInterface::class);
        $panelForDevicePresentationItemsItemTransformer->method('transform')->willReturn($panelForDevicePresentationItemsItemModel);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new PanelForDevicePresentationTransformer($panelForDevicePresentationItemsItemTransformer, $visibleConditionTransformer);
        $base = [PanelForDevicePresentationTransformerInterface::KEY_ITEMS => ['test-nested']];

        self::assertNull($transformer->transform($base)->getVisibleConditions());
        self::assertNull($transformer->transform($base + [PanelForDevicePresentationTransformerInterface::KEY_VISIBLE_CONDITIONS => 'test-not-array'])->getVisibleConditions());
        self::assertSame([$visibleConditionModel], $transformer->transform($base + [PanelForDevicePresentationTransformerInterface::KEY_VISIBLE_CONDITIONS => [['test-nested'], 'test-skipped']])->getVisibleConditions());
    }
}
