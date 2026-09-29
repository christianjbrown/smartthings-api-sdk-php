<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\PlayPauseState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayPauseStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayPauseStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PlayPauseState::class)]
#[CoversClass(PlayPauseStateTransformer::class)]
final class PlayPauseStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value',
            PlayPauseStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
            PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play',
            PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause',
            PlayPauseStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
        ];

        $transformer = new PlayPauseStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
        self::assertSame('test-play', $actual->getPlay());
        self::assertSame('test-pause', $actual->getPause());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new PlayPauseStateTransformer($alternativeItemTransformer);
        $base = [PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [PlayPauseStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [PlayPauseStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PlayPauseStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[PlayPauseStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[PlayPauseStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new PlayPauseStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause']);

        self::assertNull($actual->getValueType());
        self::assertNull($actual->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayPauseStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'valueAbsent' => [[PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause'], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause', PlayPauseStateTransformerInterface::KEY_VALUE => 42], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_VALUE)];
        yield 'playAbsent' => [[PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause'], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_PLAY)];
        yield 'playWrongType' => [[PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PAUSE => 'test-pause', PlayPauseStateTransformerInterface::KEY_PLAY => 42], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_PLAY)];
        yield 'pauseAbsent' => [[PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play'], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_PAUSE)];
        yield 'pauseWrongType' => [[PlayPauseStateTransformerInterface::KEY_VALUE => 'test-value', PlayPauseStateTransformerInterface::KEY_PLAY => 'test-play', PlayPauseStateTransformerInterface::KEY_PAUSE => 42], sprintf(PlayPauseStateTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayPauseStateTransformerInterface::KEY_PAUSE)];
    }
}
