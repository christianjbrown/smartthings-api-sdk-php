<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\RuleDeviceCommand;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use ChristianBrown\SmartThings\Transformer\Action\RuleDeviceCommandNodeTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(RuleDeviceCommandNodeTransformer::class)]
#[UsesClass(RuleDeviceCommand::class)]
final class RuleDeviceCommandNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new RuleDeviceCommandNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(RuleDeviceCommand::class, $model);
    }
}
