<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer\Action;

use ChristianBrown\SmartThings\Model\SleepActionInterface;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryInterface;
use ChristianBrown\SmartThings\Serializer\Action\SleepActionNodeSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionSerializerTest; this pins that a model with
 * nothing nested set serializes, with its unset optionals omitted, without asking the registry for anything.
 */
#[CoversClass(SleepActionNodeSerializer::class)]
final class SleepActionNodeSerializerTest extends TestCase
{
    public function testSerializeWithNothingNested(): void
    {
        $registry = $this->createMock(NodeSerializerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $serialized = (new SleepActionNodeSerializer())->serialize(self::createStub(SleepActionInterface::class), $registry);

        self::assertNotContains(null, $serialized);
    }
}
