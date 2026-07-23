<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilitiesTransformer::class)]
final class CapabilitiesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-capability-1'], ['test-capability-2']];

        $capability1 = self::createStub(CapabilityInterface::class);
        $capability2 = self::createStub(CapabilityInterface::class);
        $capabilities = [$capability1, $capability2];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-capability-1'], $capability1],
                    [['test-capability-2'], $capability2],
                ]
            );

        $transformer = new CapabilitiesTransformer($capabilityTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($capabilities, $actual);
    }

    public function testTransformEmpty(): void
    {
        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $transformer = new CapabilitiesTransformer($capabilityTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $capability1 = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with(['test-capability-1'])
            ->willReturn($capability1);

        $transformer = new CapabilitiesTransformer($capabilityTransformer);

        self::assertSame([$capability1], $transformer->transform([['test-capability-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $transformer = new CapabilitiesTransformer($capabilityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CapabilitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-capability-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-capability-1-array'], 'test-capability-2-not-array', ['test-capability-3-array'], 'test-capability-4-not-array'];

        $capability1 = self::createStub(CapabilityInterface::class);
        $capability3 = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilityTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-capability-1-array'], $capability1],
                    [['test-capability-3-array'], $capability3],
                ]
            );

        $transformer = new CapabilitiesTransformer($capabilityTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilitiesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CapabilitiesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
