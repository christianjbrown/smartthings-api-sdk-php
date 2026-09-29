<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayStopCommand;
use ChristianBrown\SmartThings\Transformer\PlayStopCommandTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PlayStopCommand::class)]
#[CoversClass(PlayStopCommandTransformer::class)]
final class PlayStopCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PlayStopCommandTransformerInterface::KEY_NAME => 'test-name',
            PlayStopCommandTransformerInterface::KEY_PLAY => 'test-play',
            PlayStopCommandTransformerInterface::KEY_STOP => 'test-stop',
            PlayStopCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type',
        ];

        $transformer = new PlayStopCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-play', $actual->getPlay());
        self::assertSame('test-stop', $actual->getStop());
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
        $transformer = new PlayStopCommandTransformer();

        $actual = $transformer->transform([PlayStopCommandTransformerInterface::KEY_PLAY => 'test-play', PlayStopCommandTransformerInterface::KEY_STOP => 'test-stop'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[PlayStopCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[PlayStopCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'argumentTypeAbsent' => [[], 'getArgumentType', null];
        yield 'argumentTypeWrongType' => [[PlayStopCommandTransformerInterface::KEY_ARGUMENT_TYPE => 42], 'getArgumentType', null];
        yield 'argumentTypeValid' => [[PlayStopCommandTransformerInterface::KEY_ARGUMENT_TYPE => 'test-argument-type'], 'getArgumentType', 'test-argument-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new PlayStopCommandTransformer();

        $actual = $transformer->transform([PlayStopCommandTransformerInterface::KEY_PLAY => 'test-play', PlayStopCommandTransformerInterface::KEY_STOP => 'test-stop']);

        self::assertNull($actual->getName());
        self::assertNull($actual->getArgumentType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayStopCommandTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'playAbsent' => [[PlayStopCommandTransformerInterface::KEY_STOP => 'test-stop'], sprintf(PlayStopCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayStopCommandTransformerInterface::KEY_PLAY)];
        yield 'playWrongType' => [[PlayStopCommandTransformerInterface::KEY_STOP => 'test-stop', PlayStopCommandTransformerInterface::KEY_PLAY => 42], sprintf(PlayStopCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayStopCommandTransformerInterface::KEY_PLAY)];
        yield 'stopAbsent' => [[PlayStopCommandTransformerInterface::KEY_PLAY => 'test-play'], sprintf(PlayStopCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayStopCommandTransformerInterface::KEY_STOP)];
        yield 'stopWrongType' => [[PlayStopCommandTransformerInterface::KEY_PLAY => 'test-play', PlayStopCommandTransformerInterface::KEY_STOP => 42], sprintf(PlayStopCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayStopCommandTransformerInterface::KEY_STOP)];
    }
}
