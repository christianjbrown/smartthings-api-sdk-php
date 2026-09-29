<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForDashboardStateTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityValueForDashboardStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityValueForDashboardState::class)]
#[CoversClass(CapabilityValueForDashboardStateTransformer::class)]
final class CapabilityValueForDashboardStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            CapabilityValueForDashboardStateTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityValueForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new CapabilityValueForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new CapabilityValueForDashboardStateTransformer($alternativeItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [CapabilityValueForDashboardStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [CapabilityValueForDashboardStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityValueForDashboardStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityValueForDashboardStateTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityValueForDashboardStateTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new CapabilityValueForDashboardStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getAlternatives());
    }
}
