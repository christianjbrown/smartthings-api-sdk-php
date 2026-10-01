<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer\Action;

use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;
use ChristianBrown\SmartThings\Serializer\Action\IfActionSequenceNodeSerializer;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionSerializerTest; this pins that a model with
 * nothing nested set serializes, with its unset optionals omitted, without asking the registry for anything.
 */
#[CoversClass(IfActionSequenceNodeSerializer::class)]
final class IfActionSequenceNodeSerializerTest extends TestCase
{
    public function testSerializeWithNothingNested(): void
    {
        $registry = $this->createMock(NodeSerializerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $serialized = (new IfActionSequenceNodeSerializer())->serialize(self::createStub(IfActionSequenceInterface::class), $registry);

        self::assertNotContains(null, $serialized);
    }
}
