<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\IfActionSequence;
use ChristianBrown\SmartThings\Transformer\Action\IfActionSequenceNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(IfActionSequenceNodeTransformer::class)]
#[UsesClass(IfActionSequence::class)]
final class IfActionSequenceNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new IfActionSequenceNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(IfActionSequence::class, $model);
    }
}
