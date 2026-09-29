<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItem;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsStateItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusProgressBarsStateItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(BasicPlusProgressBarsStateItem::class)]
#[CoversClass(BasicPlusProgressBarsStateItemTransformer::class)]
final class BasicPlusProgressBarsStateItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $data = [
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label',
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_VERSION => 7,
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_FORMAT_INFO => [['test-nested']],
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            BasicPlusProgressBarsStateItemTransformerInterface::KEY_PLACEMENT => 'test-placement',
        ];

        $transformer = new BasicPlusProgressBarsStateItemTransformer($alternativeItemTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $actual->getFormatInfo());
        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame('test-placement', $actual->getPlacement());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new BasicPlusProgressBarsStateItemTransformer($alternativeItemTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);
        $base = [BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [BasicPlusProgressBarsStateItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [BasicPlusProgressBarsStateItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    public function testTransformFormatInfo(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new BasicPlusProgressBarsStateItemTransformer($alternativeItemTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);
        $base = [BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component'];

        self::assertNull($transformer->transform($base)->getFormatInfo());
        self::assertNull($transformer->transform($base + [BasicPlusProgressBarsStateItemTransformerInterface::KEY_FORMAT_INFO => 'test-not-array'])->getFormatInfo());
        self::assertSame([$deviceConfigEntryForDashboardStateFormatInfoItemModel], $transformer->transform($base + [BasicPlusProgressBarsStateItemTransformerInterface::KEY_FORMAT_INFO => [['test-nested'], 'test-skipped']])->getFormatInfo());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusProgressBarsStateItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
        yield 'iconUrlValid' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'], 'getIconUrl', 'test-icon-url'];
        yield 'placementAbsent' => [[], 'getPlacement', null];
        yield 'placementWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_PLACEMENT => 42], 'getPlacement', null];
        yield 'placementValid' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_PLACEMENT => 'test-placement'], 'getPlacement', 'test-placement'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $deviceConfigEntryForDashboardStateFormatInfoItemModel = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer = self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class);
        $deviceConfigEntryForDashboardStateFormatInfoItemTransformer->method('transform')->willReturn($deviceConfigEntryForDashboardStateFormatInfoItemModel);
        $transformer = new BasicPlusProgressBarsStateItemTransformer($alternativeItemTransformer, $deviceConfigEntryForDashboardStateFormatInfoItemTransformer);

        $actual = $transformer->transform([BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component']);

        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getFormatInfo());
        self::assertNull($actual->getIconUrl());
        self::assertNull($actual->getPlacement());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new BasicPlusProgressBarsStateItemTransformer(self::createStub(AlternativeItemTransformerInterface::class), self::createStub(DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 42], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL)];
        yield 'capabilityAbsent' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component'], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 42], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY)];
        yield 'componentAbsent' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT)];
        yield 'componentWrongType' => [[BasicPlusProgressBarsStateItemTransformerInterface::KEY_LABEL => 'test-label', BasicPlusProgressBarsStateItemTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT => 42], sprintf(BasicPlusProgressBarsStateItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, BasicPlusProgressBarsStateItemTransformerInterface::KEY_COMPONENT)];
    }
}
