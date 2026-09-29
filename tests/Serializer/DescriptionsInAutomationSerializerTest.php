<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionItemInterface;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomation;
use ChristianBrown\SmartThings\Serializer\DescriptionItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\DescriptionsInAutomationSerializer;
use ChristianBrown\SmartThings\Serializer\DescriptionsInAutomationSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DescriptionsInAutomation::class)]
#[CoversClass(DescriptionsInAutomationSerializer::class)]
final class DescriptionsInAutomationSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemSerializer = self::createStub(DescriptionItemSerializerInterface::class);
        $descriptionItemSerializer->method('serialize')->willReturn(['test-serialized-description-item']);
        $model = new DescriptionsInAutomation();

        $serializer = new DescriptionsInAutomationSerializer($descriptionItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $descriptionItemModel = self::createStub(DescriptionItemInterface::class);
        $descriptionItemSerializer = self::createStub(DescriptionItemSerializerInterface::class);
        $descriptionItemSerializer->method('serialize')->willReturn(['test-serialized-description-item']);
        $model = (new DescriptionsInAutomation())
            ->setConditions([$descriptionItemModel])
            ->setActions([$descriptionItemModel]);

        $serializer = new DescriptionsInAutomationSerializer($descriptionItemSerializer);

        self::assertSame(
            [
                DescriptionsInAutomationSerializerInterface::KEY_CONDITIONS => [['test-serialized-description-item']],
                DescriptionsInAutomationSerializerInterface::KEY_ACTIONS => [['test-serialized-description-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
