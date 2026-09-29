<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayPauseCommand;
use ChristianBrown\SmartThings\Transformer\PlayPauseCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PlayPauseCommand::class)]
#[CoversClass(PlayPauseCommandTransformer::class)]
final class PlayPauseCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PlayPauseCommandTransformerInterface::KEY_NAME => 'test-name',
            PlayPauseCommandTransformerInterface::KEY_PLAY => 'test-play',
            PlayPauseCommandTransformerInterface::KEY_PAUSE => 'test-pause',
            PlayPauseCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new PlayPauseCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-play', $actual->getPlay());
        self::assertSame('test-pause', $actual->getPause());
        self::assertSame('test-argument-type', $actual->getArgumentType());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PlayPauseCommandTransformer();

        $actual = $transformer->transform([PlayPauseCommandTransformerInterface::KEY_PLAY => 'test-play', PlayPauseCommandTransformerInterface::KEY_PAUSE => 'test-pause'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[PlayPauseCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[PlayPauseCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[PlayPauseCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[PlayPauseCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PlayPauseCommandTransformer();

        $actual = $transformer->transform([PlayPauseCommandTransformerInterface::KEY_PLAY => 'test-play', PlayPauseCommandTransformerInterface::KEY_PAUSE => 'test-pause']);

        self::assertNull($actual->getName());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayPauseCommandTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'playAbsent' => [[PlayPauseCommandTransformerInterface::KEY_PAUSE => 'test-pause'], sprintf(PlayPauseCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseCommandTransformerInterface::KEY_PLAY)];
        yield 'playWrongType' => [[PlayPauseCommandTransformerInterface::KEY_PAUSE => 'test-pause', PlayPauseCommandTransformerInterface::KEY_PLAY => 42], sprintf(PlayPauseCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseCommandTransformerInterface::KEY_PLAY)];
        yield 'pauseAbsent' => [[PlayPauseCommandTransformerInterface::KEY_PLAY => 'test-play'], sprintf(PlayPauseCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseCommandTransformerInterface::KEY_PAUSE)];
        yield 'pauseWrongType' => [[PlayPauseCommandTransformerInterface::KEY_PLAY => 'test-play', PlayPauseCommandTransformerInterface::KEY_PAUSE => 42], sprintf(PlayPauseCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseCommandTransformerInterface::KEY_PAUSE)];
    }
}
