<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SceneInterface;
use ChristianBrown\SmartThings\Transformer\ScenesTransformer;
use ChristianBrown\SmartThings\Transformer\ScenesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SceneTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ScenesTransformer::class)]
final class ScenesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-scene-1'], ['test-scene-2']];

        $scene1 = self::createStub(SceneInterface::class);
        $scene2 = self::createStub(SceneInterface::class);
        $scenes = [$scene1, $scene2];

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);
        $sceneTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-scene-1'], $scene1],
                    [['test-scene-2'], $scene2],
                ]
            );

        $transformer = new ScenesTransformer($sceneTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($scenes, $actual);
    }

    public function testTransformEmpty(): void
    {
        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $transformer = new ScenesTransformer($sceneTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $scene1 = self::createStub(SceneInterface::class);

        $sceneTransformer = self::createMock(SceneTransformerInterface::class);
        $sceneTransformer->expects(self::once())->method('transform')
            ->with(['test-scene-1'])
            ->willReturn($scene1);

        $transformer = new ScenesTransformer($sceneTransformer);

        self::assertSame([$scene1], $transformer->transform([['test-scene-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $transformer = new ScenesTransformer($sceneTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ScenesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ScenesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-scene-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-scene-1-array'], 'test-scene-2-not-array', ['test-scene-3-array'], 'test-scene-4-not-array'];

        $scene1 = self::createStub(SceneInterface::class);
        $scene3 = self::createStub(SceneInterface::class);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);
        $sceneTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-scene-1-array'], $scene1],
                    [['test-scene-3-array'], $scene3],
                ]
            );

        $transformer = new ScenesTransformer($sceneTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ScenesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ScenesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
