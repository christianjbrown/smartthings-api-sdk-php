<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PlayPause;
use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;
use ChristianBrown\SmartThings\Model\PlayPauseStateInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayPause::class)]
#[CoversClass(PlayPauseTransformer::class)]
final class PlayPauseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $playPauseCommandModel = self::createStub(PlayPauseCommandInterface::class);
        $playPauseCommandTransformer = self::createStub(PlayPauseCommandTransformerInterface::class);
        $playPauseCommandTransformer->method('transform')->willReturn($playPauseCommandModel);
        $playPauseStateModel = self::createStub(PlayPauseStateInterface::class);
        $playPauseStateTransformer = self::createStub(PlayPauseStateTransformerInterface::class);
        $playPauseStateTransformer->method('transform')->willReturn($playPauseStateModel);
        $data = [
            PlayPauseTransformerInterface::KEY_COMMAND => ['test-nested'],
            PlayPauseTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new PlayPauseTransformer($playPauseCommandTransformer, $playPauseStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($playPauseCommandModel, $actual->getCommand());
        self::assertSame($playPauseStateModel, $actual->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PlayPauseTransformer(self::createStub(PlayPauseCommandTransformerInterface::class), self::createStub(PlayPauseStateTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'commandAbsent' => [[PlayPauseTransformerInterface::KEY_STATE => ['test-nested']], 'getCommand', null];
        yield 'commandWrongType' => [[PlayPauseTransformerInterface::KEY_STATE => ['test-nested'], PlayPauseTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
        yield 'stateAbsent' => [[PlayPauseTransformerInterface::KEY_COMMAND => ['test-nested']], 'getState', null];
        yield 'stateWrongType' => [[PlayPauseTransformerInterface::KEY_COMMAND => ['test-nested'], PlayPauseTransformerInterface::KEY_STATE => 'not-array'], 'getState', null];
    }
}
