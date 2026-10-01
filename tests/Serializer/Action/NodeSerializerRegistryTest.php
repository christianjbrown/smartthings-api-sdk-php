<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer\Action;

use ChristianBrown\SmartThings\Exception\UnregisteredTypeException;
use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistry;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(NodeSerializerRegistry::class)]
#[UsesClass(UnregisteredTypeException::class)]
final class NodeSerializerRegistryTest extends TestCase
{
    public function testGetReturnsTheTransformerRegisteredForTheType(): void
    {
        $serializer = self::createStub(NodeSerializerInterface::class);

        $registry = new NodeSerializerRegistry([ActionInterface::class => $serializer]);

        self::assertSame($serializer, $registry->get(ActionInterface::class));
    }

    public function testGetThrowsForAnUnregisteredType(): void
    {
        $registry = new NodeSerializerRegistry([ActionInterface::class => self::createStub(NodeSerializerInterface::class)]);

        $this->expectException(UnregisteredTypeException::class);
        $this->expectExceptionMessage(sprintf(NodeSerializerRegistryInterface::UNREGISTERED_TYPE_SPRINTF, OperandInterface::class));

        $registry->get(OperandInterface::class);
    }
}
