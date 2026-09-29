<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DescriptionItemInterface;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomation;
use ChristianBrown\SmartThings\Transformer\DescriptionItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformer;
use ChristianBrown\SmartThings\Transformer\DescriptionsInAutomationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DescriptionsInAutomation::class)]
#[CoversClass(DescriptionsInAutomationTransformer::class)]
final class DescriptionsInAutomationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemTransformer = self::createStub(DescriptionItemTransformerInterface::class);
        $descriptionItemTransformer->method('transform')->willReturn($descriptionItemModel);
        $data = [
            DescriptionsInAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested']],
            DescriptionsInAutomationTransformerInterface::KEY_ACTIONS => [['test-nested']],
        ];

        $transformer = new DescriptionsInAutomationTransformer($descriptionItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$descriptionItemModel], $actual->getConditions());
        self::assertSame([$descriptionItemModel], $actual->getActions());
    }

    public function testTransformActions(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemTransformer = self::createStub(DescriptionItemTransformerInterface::class);
        $descriptionItemTransformer->method('transform')->willReturn($descriptionItemModel);
        $transformer = new DescriptionsInAutomationTransformer($descriptionItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getActions());
        self::assertNull($transformer->transform($base + [DescriptionsInAutomationTransformerInterface::KEY_ACTIONS => 'test-not-array'])->getActions());
        self::assertSame([$descriptionItemModel], $transformer->transform($base + [DescriptionsInAutomationTransformerInterface::KEY_ACTIONS => [['test-nested'], 'test-skipped']])->getActions());
    }

    public function testTransformConditions(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemTransformer = self::createStub(DescriptionItemTransformerInterface::class);
        $descriptionItemTransformer->method('transform')->willReturn($descriptionItemModel);
        $transformer = new DescriptionsInAutomationTransformer($descriptionItemTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getConditions());
        self::assertNull($transformer->transform($base + [DescriptionsInAutomationTransformerInterface::KEY_CONDITIONS => 'test-not-array'])->getConditions());
        self::assertSame([$descriptionItemModel], $transformer->transform($base + [DescriptionsInAutomationTransformerInterface::KEY_CONDITIONS => [['test-nested'], 'test-skipped']])->getConditions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemTransformer = self::createStub(DescriptionItemTransformerInterface::class);
        $descriptionItemTransformer->method('transform')->willReturn($descriptionItemModel);
        $transformer = new DescriptionsInAutomationTransformer($descriptionItemTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getConditions());
        self::assertNull($actual->getActions());
    }
}
