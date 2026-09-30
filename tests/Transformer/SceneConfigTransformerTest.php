<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SceneConfig;
use ChristianBrown\SmartThings\Transformer\SceneConfigTransformer;
use ChristianBrown\SmartThings\Transformer\SceneConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SceneConfigTransformer::class)]
#[CoversClass(SceneConfig::class)]
#[CoversClass(ValueReader::class)]
final class SceneConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new SceneConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getSceneId());
        self::assertSame([], $actual->getPermissions());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new SceneConfigTransformer(new ValueReader()))->transform([
            SceneConfigTransformerInterface::KEY_SCENE_ID => 'test-sceneId',
            SceneConfigTransformerInterface::KEY_PERMISSIONS => ['test-permissions-1', 'test-permissions-2'],
        ]);

        self::assertSame('test-sceneId', $actual->getSceneId());
        self::assertSame(['test-permissions-1', 'test-permissions-2'], $actual->getPermissions());
    }
}
