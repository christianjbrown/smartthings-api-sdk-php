<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Scene;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Scene::class)]
#[CoversClass(SceneTransformer::class)]
final class SceneTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SceneTransformerInterface::KEY_SCENE_ID => 'test-scene-id',
            SceneTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            SceneTransformerInterface::KEY_SCENE_NAME => 'test-scene-name',
        ];

        $transformer = new SceneTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-scene-id', $actual->getSceneId());
        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('test-scene-name', $actual->getSceneName());
    }

    /**
     * Exercises the optional locationId and sceneName fields in each of their
     * three states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedLocationId, ?string $expectedSceneName): void
    {
        $transformer = new SceneTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-scene-id', $actual->getSceneId());
        self::assertSame($expectedLocationId, $actual->getLocationId());
        self::assertSame($expectedSceneName, $actual->getSceneName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $locationIdStates = [
            'locationIdAbsent' => [null, null],
            'locationIdWrongType' => [42, null],
            'locationIdValid' => ['test-location-id', 'test-location-id'],
        ];
        $sceneNameStates = [
            'sceneNameAbsent' => [null, null],
            'sceneNameWrongType' => [42, null],
            'sceneNameValid' => ['test-scene-name', 'test-scene-name'],
        ];

        foreach ($locationIdStates as $locationIdName => [$locationIdValue, $expectedLocationId]) {
            foreach ($sceneNameStates as $sceneNameName => [$sceneNameValue, $expectedSceneName]) {
                $data = [SceneTransformerInterface::KEY_SCENE_ID => 'test-scene-id'];
                if (null !== $locationIdValue) {
                    $data[SceneTransformerInterface::KEY_LOCATION_ID] = $locationIdValue;
                }
                if (null !== $sceneNameValue) {
                    $data[SceneTransformerInterface::KEY_SCENE_NAME] = $sceneNameValue;
                }

                yield sprintf('%s, %s', $locationIdName, $sceneNameName) => [$data, $expectedLocationId, $expectedSceneName];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SceneTransformerInterface::KEY_SCENE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new SceneTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SceneTransformerInterface::UNEXPECTED_STRING_SPRINTF, SceneTransformerInterface::KEY_SCENE_ID));
        $transformer->transform($data);
    }
}
