<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\SleepAction;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use ChristianBrown\SmartThings\Transformer\Action\SleepActionNodeTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(SleepActionNodeTransformer::class)]
#[UsesClass(SleepAction::class)]
final class SleepActionNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new SleepActionNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(SleepAction::class, $model);
    }
}
