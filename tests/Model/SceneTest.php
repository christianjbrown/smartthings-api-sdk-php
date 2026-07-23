<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Scene;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Scene::class)]
final class SceneTest extends TestCase
{
    public function test(): void
    {
        $scene = new Scene('test-scene-id');
        self::assertSame('test-scene-id', $scene->getSceneId());
        self::assertNull($scene->getLocationId());
        self::assertNull($scene->getSceneName());

        self::assertSame($scene, $scene->setSceneId('test-new-scene-id'));
        self::assertSame($scene, $scene->setLocationId('test-location-id'));
        self::assertSame($scene, $scene->setSceneName('test-scene-name'));

        self::assertSame('test-new-scene-id', $scene->getSceneId());
        self::assertSame('test-location-id', $scene->getLocationId());
        self::assertSame('test-scene-name', $scene->getSceneName());
    }
}
