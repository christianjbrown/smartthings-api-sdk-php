<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeStateInterface;
use ChristianBrown\SmartThings\Model\CapabilityStatus;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityStatusTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityStatusTransformer::class)]
#[CoversClass(CapabilityStatus::class)]
final class CapabilityStatusTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformKeysTheAttributeStatesByName(): void
    {
        $switchState = self::createStub(AttributeStateInterface::class);
        $attributeStateTransformer = self::createMock(AttributeStateTransformerInterface::class);
        $attributeStateTransformer->expects(self::once())->method('transform')
            ->with(['value' => 'on'])
            ->willReturn($switchState);

        $actual = (new CapabilityStatusTransformer($attributeStateTransformer))->transform(['switch' => ['value' => 'on'], 'skipped' => 'not-an-array']);

        self::assertSame(['switch' => $switchState], $actual->getAttributes());
    }
}
