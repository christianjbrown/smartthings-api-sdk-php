<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceComponentInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceComponentsTransformer::class)]
final class DeviceComponentsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-component-1'], ['test-component-2']];

        $component1 = self::createStub(DeviceComponentInterface::class);
        $component2 = self::createStub(DeviceComponentInterface::class);
        $components = [$component1, $component2];

        $componentTransformer = self::createStub(DeviceComponentTransformerInterface::class);
        $componentTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-component-1'], $component1],
                    [['test-component-2'], $component2],
                ]
            );

        $transformer = new DeviceComponentsTransformer($componentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($components, $actual);
    }

    public function testTransformEmpty(): void
    {
        $componentTransformer = self::createStub(DeviceComponentTransformerInterface::class);

        $transformer = new DeviceComponentsTransformer($componentTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $component1 = self::createStub(DeviceComponentInterface::class);

        $componentTransformer = self::createMock(DeviceComponentTransformerInterface::class);
        $componentTransformer->expects(self::once())->method('transform')
            ->with(['test-component-1'])
            ->willReturn($component1);

        $transformer = new DeviceComponentsTransformer($componentTransformer);

        self::assertSame([$component1], $transformer->transform([['test-component-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $componentTransformer = self::createStub(DeviceComponentTransformerInterface::class);

        $transformer = new DeviceComponentsTransformer($componentTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-component-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-component-1-array'], 'test-component-2-not-array', ['test-component-3-array'], 'test-component-4-not-array'];

        $component1 = self::createStub(DeviceComponentInterface::class);
        $component3 = self::createStub(DeviceComponentInterface::class);

        $componentTransformer = self::createStub(DeviceComponentTransformerInterface::class);
        $componentTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-component-1-array'], $component1],
                    [['test-component-3-array'], $component3],
                ]
            );

        $transformer = new DeviceComponentsTransformer($componentTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
