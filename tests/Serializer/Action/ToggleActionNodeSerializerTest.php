<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer\Action;

use ChristianBrown\SmartThings\Model\ToggleActionInterface;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryInterface;
use ChristianBrown\SmartThings\Serializer\Action\ToggleActionNodeSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionSerializerTest; this pins that a model with
 * nothing nested set serializes, with its unset optionals omitted, without asking the registry for anything.
 */
#[CoversClass(ToggleActionNodeSerializer::class)]
final class ToggleActionNodeSerializerTest extends TestCase
{
    public function testSerializeWithNothingNested(): void
    {
        $registry = $this->createMock(NodeSerializerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $serialized = (new ToggleActionNodeSerializer())->serialize(self::createStub(ToggleActionInterface::class), $registry);

        self::assertNotContains(null, $serialized);
    }
}
