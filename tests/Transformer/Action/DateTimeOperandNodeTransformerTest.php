<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\DateTimeOperand;
use ChristianBrown\SmartThings\Transformer\Action\DateTimeOperandNodeTransformer;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(DateTimeOperandNodeTransformer::class)]
#[UsesClass(DateTimeOperand::class)]
final class DateTimeOperandNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new DateTimeOperandNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(DateTimeOperand::class, $model);
    }
}
