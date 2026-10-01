<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequest;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;
use ChristianBrown\SmartThings\Transformer\Action\SceneDeviceGroupRequestNodeTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Nested types are covered by the round-trip cases in ActionTransformerTest; this pins that an empty
 * object builds the model without asking the registry for anything.
 */
#[CoversClass(SceneDeviceGroupRequestNodeTransformer::class)]
#[UsesClass(SceneDeviceGroupRequest::class)]
final class SceneDeviceGroupRequestNodeTransformerTest extends TestCase
{
    public function testTransformEmptyObject(): void
    {
        $registry = $this->createMock(NodeTransformerRegistryInterface::class);
        $registry->expects(self::never())->method('get');

        $model = (new SceneDeviceGroupRequestNodeTransformer())->transform([], $registry);

        self::assertInstanceOf(SceneDeviceGroupRequest::class, $model);
    }
}
