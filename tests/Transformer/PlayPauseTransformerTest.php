<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
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

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayPauseTransformer(self::createStub(PlayPauseCommandTransformerInterface::class), self::createStub(PlayPauseStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[PlayPauseTransformerInterface::KEY_STATE => ['test-nested']], sprintf(PlayPauseTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayPauseTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[PlayPauseTransformerInterface::KEY_STATE => ['test-nested'], PlayPauseTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(PlayPauseTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayPauseTransformerInterface::KEY_COMMAND)];
        yield 'stateAbsent' => [[PlayPauseTransformerInterface::KEY_COMMAND => ['test-nested']], sprintf(PlayPauseTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayPauseTransformerInterface::KEY_STATE)];
        yield 'stateWrongType' => [[PlayPauseTransformerInterface::KEY_COMMAND => ['test-nested'], PlayPauseTransformerInterface::KEY_STATE => 'not-array'], sprintf(PlayPauseTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayPauseTransformerInterface::KEY_STATE)];
    }
}
