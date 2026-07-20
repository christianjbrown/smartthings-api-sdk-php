<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceComponentCapabilityInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceComponentCapabilitiesTransformer::class)]
final class DeviceComponentCapabilitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-capability-1'], ['test-capability-2']];

        $capability1 = self::createStub(DeviceComponentCapabilityInterface::class);
        $capability2 = self::createStub(DeviceComponentCapabilityInterface::class);
        $capabilities = [$capability1, $capability2];

        $capabilityTransformer = self::createStub(DeviceComponentCapabilityTransformerInterface::class);
        $capabilityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-capability-1'], $capability1],
                    [['test-capability-2'], $capability2],
                ]
            );

        $transformer = new DeviceComponentCapabilitiesTransformer($capabilityTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($capabilities, $actual);
    }

    public function testTransformEmpty(): void
    {
        $capabilityTransformer = self::createStub(DeviceComponentCapabilityTransformerInterface::class);

        $transformer = new DeviceComponentCapabilitiesTransformer($capabilityTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $capability1 = self::createStub(DeviceComponentCapabilityInterface::class);

        $capabilityTransformer = self::createMock(DeviceComponentCapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with(['test-capability-1'])
            ->willReturn($capability1);

        $transformer = new DeviceComponentCapabilitiesTransformer($capabilityTransformer);

        self::assertSame([$capability1], $transformer->transform([['test-capability-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $capabilityTransformer = self::createStub(DeviceComponentCapabilityTransformerInterface::class);

        $transformer = new DeviceComponentCapabilitiesTransformer($capabilityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentCapabilitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentCapabilitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-capability-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-capability-1-array'], 'test-capability-2-not-array', ['test-capability-3-array'], 'test-capability-4-not-array'];

        $capability1 = self::createStub(DeviceComponentCapabilityInterface::class);
        $capability3 = self::createStub(DeviceComponentCapabilityInterface::class);

        $capabilityTransformer = self::createStub(DeviceComponentCapabilityTransformerInterface::class);
        $capabilityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-capability-1-array'], $capability1],
                    [['test-capability-3-array'], $capability3],
                ]
            );

        $transformer = new DeviceComponentCapabilitiesTransformer($capabilityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentCapabilitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentCapabilitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
