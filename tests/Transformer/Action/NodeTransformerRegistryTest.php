<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeException;
use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistry;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NodeTransformerRegistry::class)]
#[UsesClass(UnregisteredTypeException::class)]
final class NodeTransformerRegistryTest extends TestCase
{
    public function testGetReturnsTheTransformerRegisteredForTheType(): void
    {
        $transformer = self::createStub(NodeTransformerInterface::class);

        $registry = new NodeTransformerRegistry([ActionInterface::class => $transformer]);

        self::assertSame($transformer, $registry->get(ActionInterface::class));
    }

    public function testGetThrowsForAnUnregisteredType(): void
    {
        $registry = new NodeTransformerRegistry([ActionInterface::class => self::createStub(NodeTransformerInterface::class)]);

        $this->expectException(UnregisteredTypeException::class);
        $this->expectExceptionMessage(sprintf(NodeTransformerRegistryInterface::UNREGISTERED_TYPE_SPRINTF, OperandInterface::class));

        $registry->get(OperandInterface::class);
    }
}
