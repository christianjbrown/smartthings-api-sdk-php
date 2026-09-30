<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceComponent;
use ChristianBrown\SmartThings\Model\DeviceComponentCapabilityInterface;
use ChristianBrown\SmartThings\Model\RestrictionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceCategoryTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentCapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceComponentTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RestrictionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceComponent::class)]
#[CoversClass(DeviceComponentTransformer::class)]
#[CoversClass(ValueReader::class)]
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

        $transformer = new DeviceComponentTransformer($capabilitiesTransformer, new ValueReader(), self::createStub(DeviceCategoryTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($capabilities, $actual->getCapabilities());
    }

    public function testTransformLeavesTheComponentDetailsUnsetWhenAbsent(): void
    {
        $capabilitiesTransformer = self::createStub(DeviceComponentCapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->method('transform')->willReturn([]);

        $actual = (new DeviceComponentTransformer($capabilitiesTransformer, new ValueReader(), self::createStub(DeviceCategoryTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class)))->transform([
            DeviceComponentTransformerInterface::KEY_CAPABILITIES => [['id' => 'switch']],
        ]);

        self::assertNull($actual->getId());
        self::assertNull($actual->getOptional());
        self::assertSame([], $actual->getCategories());
        self::assertNull($actual->getRestrictions());
    }

    public function testTransformReadsTheComponentDetails(): void
    {
        $capabilitiesTransformer = self::createStub(DeviceComponentCapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->method('transform')->willReturn([]);
        $category = self::createStub(DeviceCategoryInterface::class);
        $categoryTransformer = self::createMock(DeviceCategoryTransformerInterface::class);
        $categoryTransformer->expects(self::once())->method('transform')->with(['name' => 'Light'])->willReturn($category);
        $restriction = self::createStub(RestrictionInterface::class);
        $restrictionTransformer = self::createMock(RestrictionTransformerInterface::class);
        $restrictionTransformer->expects(self::once())->method('transform')->with(['tier' => 1])->willReturn($restriction);

        $actual = (new DeviceComponentTransformer($capabilitiesTransformer, new ValueReader(), $categoryTransformer, $restrictionTransformer))->transform([
            DeviceComponentTransformerInterface::KEY_CAPABILITIES => [['id' => 'switch']],
            DeviceComponentTransformerInterface::KEY_ID => 'main',
            DeviceComponentTransformerInterface::KEY_LABEL => 'Main',
            DeviceComponentTransformerInterface::KEY_OPTIONAL => true,
            DeviceComponentTransformerInterface::KEY_CATEGORIES => [['name' => 'Light']],
            DeviceComponentTransformerInterface::KEY_RESTRICTIONS => ['tier' => 1],
        ]);

        self::assertSame('main', $actual->getId());
        self::assertSame('Main', $actual->getLabel());
        self::assertTrue($actual->getOptional());
        self::assertSame([$category], $actual->getCategories());
        self::assertSame($restriction, $actual->getRestrictions());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceComponentTransformerInterface::KEY_CAPABILITIES => 'test-not-an-array']])]
    public function testTransformUnexpectedData(array $data): void
    {
        $capabilitiesTransformer = self::createStub(DeviceComponentCapabilitiesTransformerInterface::class);
        $transformer = new DeviceComponentTransformer($capabilitiesTransformer, new ValueReader(), self::createStub(DeviceCategoryTransformerInterface::class), self::createStub(RestrictionTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceComponentTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, DeviceComponentTransformerInterface::KEY_CAPABILITIES));
        $transformer->transform($data);
    }
}
