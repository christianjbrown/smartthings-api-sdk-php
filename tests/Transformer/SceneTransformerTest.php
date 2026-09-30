<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Scene;
use ChristianBrown\SmartThings\Transformer\SceneTransformer;
use ChristianBrown\SmartThings\Transformer\SceneTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Scene::class)]
#[CoversClass(SceneTransformer::class)]
#[CoversClass(ValueReader::class)]
final class SceneTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SceneTransformerInterface::KEY_SCENE_ID => 'test-scene-id',
            SceneTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
            SceneTransformerInterface::KEY_SCENE_NAME => 'test-scene-name',
        ];

        $transformer = new SceneTransformer(new ValueReader());

        $actual = $transformer->transform($data);

        self::assertSame('test-scene-id', $actual->getSceneId());
        self::assertSame('test-location-id', $actual->getLocationId());
        self::assertSame('test-scene-name', $actual->getSceneName());
    }

    public function testTransformLeavesTheSceneDetailsUnsetWhenAbsent(): void
    {
        $actual = (new SceneTransformer(new ValueReader()))->transform([SceneTransformerInterface::KEY_SCENE_ID => 'test-scene-id']);

        self::assertNull($actual->getSceneIcon());
        self::assertNull($actual->getEditable());
        self::assertNull($actual->getApiVersion());
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
        $transformer = new SceneTransformer(new ValueReader());

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

    public function testTransformReadsTheSceneDetails(): void
    {
        $actual = (new SceneTransformer(new ValueReader()))->transform([
            SceneTransformerInterface::KEY_SCENE_ID => 'test-scene-id',
            SceneTransformerInterface::KEY_SCENE_ICON => 'test-icon',
            SceneTransformerInterface::KEY_SCENE_COLOR => 'test-color',
            SceneTransformerInterface::KEY_CREATED_BY => 'test-creator',
            SceneTransformerInterface::KEY_CREATED_DATE => '2026-01-01T00:00:00Z',
            SceneTransformerInterface::KEY_LAST_UPDATED_DATE => '2026-01-02T00:00:00Z',
            SceneTransformerInterface::KEY_LAST_EXECUTED_DATE => '2026-01-03T00:00:00Z',
            SceneTransformerInterface::KEY_EDITABLE => true,
            SceneTransformerInterface::KEY_API_VERSION => 'test-version',
        ]);

        self::assertSame('test-icon', $actual->getSceneIcon());
        self::assertSame('test-color', $actual->getSceneColor());
        self::assertSame('test-creator', $actual->getCreatedBy());
        self::assertSame('2026-01-01T00:00:00Z', $actual->getCreatedDate());
        self::assertSame('2026-01-02T00:00:00Z', $actual->getLastUpdatedDate());
        self::assertSame('2026-01-03T00:00:00Z', $actual->getLastExecutedDate());
        self::assertTrue($actual->getEditable());
        self::assertSame('test-version', $actual->getApiVersion());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SceneTransformerInterface::KEY_SCENE_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new SceneTransformer(new ValueReader());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SceneTransformerInterface::UNEXPECTED_STRING_SPRINTF, SceneTransformerInterface::KEY_SCENE_ID));
        $transformer->transform($data);
    }
}
