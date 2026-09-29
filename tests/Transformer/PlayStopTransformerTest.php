<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayStop;
use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;
use ChristianBrown\SmartThings\Model\PlayStopStateInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PlayStop::class)]
#[CoversClass(PlayStopTransformer::class)]
final class PlayStopTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $playStopCommandModel = self::createStub(PlayStopCommandInterface::class);
        $playStopCommandTransformer = self::createStub(PlayStopCommandTransformerInterface::class);
        $playStopCommandTransformer->method('transform')->willReturn($playStopCommandModel);
        $playStopStateModel = self::createStub(PlayStopStateInterface::class);
        $playStopStateTransformer = self::createStub(PlayStopStateTransformerInterface::class);
        $playStopStateTransformer->method('transform')->willReturn($playStopStateModel);
        $data = [
            PlayStopTransformerInterface::KEY_COMMAND => ['test-nested'],
            PlayStopTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new PlayStopTransformer($playStopCommandTransformer, $playStopStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($playStopCommandModel, $actual->getCommand());
        self::assertSame($playStopStateModel, $actual->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayStopTransformer(self::createStub(PlayStopCommandTransformerInterface::class), self::createStub(PlayStopStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[PlayStopTransformerInterface::KEY_STATE => ['test-nested']], sprintf(PlayStopTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayStopTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[PlayStopTransformerInterface::KEY_STATE => ['test-nested'], PlayStopTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(PlayStopTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayStopTransformerInterface::KEY_COMMAND)];
        yield 'stateAbsent' => [[PlayStopTransformerInterface::KEY_COMMAND => ['test-nested']], sprintf(PlayStopTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayStopTransformerInterface::KEY_STATE)];
        yield 'stateWrongType' => [[PlayStopTransformerInterface::KEY_COMMAND => ['test-nested'], PlayStopTransformerInterface::KEY_STATE => 'not-array'], sprintf(PlayStopTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, PlayStopTransformerInterface::KEY_STATE)];
    }
}
