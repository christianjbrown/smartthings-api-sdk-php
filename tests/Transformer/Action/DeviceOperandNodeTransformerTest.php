<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\DeviceOperand;
use ChristianBrown\SmartThings\Transformer\Action\DeviceOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(DeviceOperandNodeTransformer::class)]
#[UsesClass(DeviceOperand::class)]
final class DeviceOperandNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new DeviceOperandNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(DeviceOperand::class, $model);
    }
}
