<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandInterface;
use ChristianBrown\SmartThings\Model\CapabilityDetails;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityDetails::class)]
#[CoversClass(CapabilityDetailsTransformer::class)]
final class CapabilityDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityAttributeModel = self::createStub(CapabilityAttributeInterface::class);
        $capabilityAttributeTransformer = self::createStub(CapabilityAttributeTransformerInterface::class);
        $capabilityAttributeTransformer->method('transform')->willReturn($capabilityAttributeModel);
        $capabilityCommandModel = self::createStub(CapabilityCommandInterface::class);
        $capabilityCommandTransformer = self::createStub(CapabilityCommandTransformerInterface::class);
        $capabilityCommandTransformer->method('transform')->willReturn($capabilityCommandModel);
        $data = [
            CapabilityDetailsTransformerInterface::KEY_ATTRIBUTES => ['test-key' => ['test-nested']],
            CapabilityDetailsTransformerInterface::KEY_COMMANDS => ['test-key' => ['test-nested']],
        ];

        $transformer = new CapabilityDetailsTransformer($capabilityAttributeTransformer, $capabilityCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-key' => $capabilityAttributeModel], $actual->getAttributes());
        self::assertSame(['test-key' => $capabilityCommandModel], $actual->getCommands());
    }

    public function testTransformAttributes(): void
    {
        $capabilityAttributeModel = self::createStub(CapabilityAttributeInterface::class);
        $capabilityAttributeTransformer = self::createStub(CapabilityAttributeTransformerInterface::class);
        $capabilityAttributeTransformer->method('transform')->willReturn($capabilityAttributeModel);
        $capabilityCommandModel = self::createStub(CapabilityCommandInterface::class);
        $capabilityCommandTransformer = self::createStub(CapabilityCommandTransformerInterface::class);
        $capabilityCommandTransformer->method('transform')->willReturn($capabilityCommandModel);
        $transformer = new CapabilityDetailsTransformer($capabilityAttributeTransformer, $capabilityCommandTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getAttributes());
        self::assertNull($transformer->transform($base + [CapabilityDetailsTransformerInterface::KEY_ATTRIBUTES => 'test-not-array'])->getAttributes());
        self::assertSame(['test-key' => $capabilityAttributeModel], $transformer->transform($base + [CapabilityDetailsTransformerInterface::KEY_ATTRIBUTES => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getAttributes());
    }

    public function testTransformCommands(): void
    {
        $capabilityAttributeModel = self::createStub(CapabilityAttributeInterface::class);
        $capabilityAttributeTransformer = self::createStub(CapabilityAttributeTransformerInterface::class);
        $capabilityAttributeTransformer->method('transform')->willReturn($capabilityAttributeModel);
        $capabilityCommandModel = self::createStub(CapabilityCommandInterface::class);
        $capabilityCommandTransformer = self::createStub(CapabilityCommandTransformerInterface::class);
        $capabilityCommandTransformer->method('transform')->willReturn($capabilityCommandModel);
        $transformer = new CapabilityDetailsTransformer($capabilityAttributeTransformer, $capabilityCommandTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCommands());
        self::assertNull($transformer->transform($base + [CapabilityDetailsTransformerInterface::KEY_COMMANDS => 'test-not-array'])->getCommands());
        self::assertSame(['test-key' => $capabilityCommandModel], $transformer->transform($base + [CapabilityDetailsTransformerInterface::KEY_COMMANDS => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getCommands());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityAttributeModel = self::createStub(CapabilityAttributeInterface::class);
        $capabilityAttributeTransformer = self::createStub(CapabilityAttributeTransformerInterface::class);
        $capabilityAttributeTransformer->method('transform')->willReturn($capabilityAttributeModel);
        $capabilityCommandModel = self::createStub(CapabilityCommandInterface::class);
        $capabilityCommandTransformer = self::createStub(CapabilityCommandTransformerInterface::class);
        $capabilityCommandTransformer->method('transform')->willReturn($capabilityCommandModel);
        $transformer = new CapabilityDetailsTransformer($capabilityAttributeTransformer, $capabilityCommandTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getAttributes());
        self::assertNull($actual->getCommands());
    }
}
