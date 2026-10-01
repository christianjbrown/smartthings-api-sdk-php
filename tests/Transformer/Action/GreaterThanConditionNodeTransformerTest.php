<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\GreaterThanCondition;
use ChristianBrown\SmartThings\Transformer\Action\GreaterThanConditionNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(GreaterThanConditionNodeTransformer::class)]
#[UsesClass(GreaterThanCondition::class)]
final class GreaterThanConditionNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new GreaterThanConditionNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(GreaterThanCondition::class, $model);
    }
}
