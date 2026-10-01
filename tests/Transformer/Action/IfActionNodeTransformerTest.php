<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\IfAction;
use ChristianBrown\SmartThings\Transformer\Action\IfActionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(IfActionNodeTransformer::class)]
#[UsesClass(IfAction::class)]
final class IfActionNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new IfActionNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(IfAction::class, $model);
    }
}
