<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceComponent;
use ChristianBrown\SmartThings\Model\DeviceComponentCapabilityInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceComponent::class)]
#[CoversClass(DeviceComponentTransformer::class)]
final class DeviceComponentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilitiesData = ['test-capability-1', 'test-capability-2'];
        $data = [
            DeviceComponentTransformerInterface::KEY_CAPABILITIES => $capabilitiesData,
        ];

        $capabilities = [
            self::createStub(DeviceComponentCapabilityInterface::class),
            self::createStub(DeviceComponentCapabilityInterface::class),
        ];

        $capabilitiesTransformer = self::createMock(DeviceComponentCapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($capabilitiesData)
            ->willReturn($capabilities);

        $transformer = new DeviceComponentTransformer($capabilitiesTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($capabilities, $actual->getCapabilities());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceComponentTransformerInterface::KEY_CAPABILITIES => 'test-not-an-array']])]
    public function testTransformUnexpectedData(array $data): void
    {
        $capabilitiesTransformer = self::createStub(DeviceComponentCapabilitiesTransformerInterface::class);
        $transformer = new DeviceComponentTransformer($capabilitiesTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentTransformerInterface::KEY_CAPABILITIES));
        $transformer->transform($data);
    }
}
