<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;
use ChristianBrown\SmartThings\Model\ComponentStatus;
use ChristianBrown\SmartThings\Transformer\CapabilityStatusTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ComponentStatusTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ComponentStatusTransformer::class)]
#[CoversClass(ComponentStatus::class)]
final class ComponentStatusTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformKeysTheCapabilityStatusesById(): void
    {
        $switchStatus = self::createStub(CapabilityStatusInterface::class);
        $capabilityStatusTransformer = self::createMock(CapabilityStatusTransformerInterface::class);
        $capabilityStatusTransformer->expects(self::once())->method('transform')
            ->with(['switch' => ['value' => 'on']])
            ->willReturn($switchStatus);

        $actual = (new ComponentStatusTransformer($capabilityStatusTransformer))->transform(['switch' => ['switch' => ['value' => 'on']], 'skipped' => 'not-an-array']);

        self::assertSame(['switch' => $switchStatus], $actual->getCapabilities());
    }
}
