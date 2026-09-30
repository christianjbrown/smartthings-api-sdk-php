<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\PlayStopState;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayStopStateTransformer;
use ChristianBrown\SmartThings\Transformer\PlayStopStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayStopState::class)]
#[CoversClass(PlayStopStateTransformer::class)]
final class PlayStopStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            PlayStopStateTransformerInterface::KEY_VALUE => 'test-value',
            PlayStopStateTransformerInterface::KEY_PLAY => 'test-play',
            PlayStopStateTransformerInterface::KEY_STOP => 'test-stop',
            PlayStopStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            PlayStopStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
        ];

        $transformer = new PlayStopStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-play', $actual->getPlay());
        self::assertSame('test-stop', $actual->getStop());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-value-type', $actual->getValueType());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new PlayStopStateTransformer($alternativeItemTransformer);
        $base = [PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [PlayStopStateTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [PlayStopStateTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PlayStopStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'valueAbsent' => [[PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop'], 'getValue', null];
        yield 'valueWrongType' => [[PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop', PlayStopStateTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'playAbsent' => [[PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop'], 'getPlay', null];
        yield 'playWrongType' => [[PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop', PlayStopStateTransformerInterface::KEY_PLAY => 42], 'getPlay', null];
        yield 'stopAbsent' => [[PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_PLAY => 'test-play'], 'getStop', null];
        yield 'stopWrongType' => [[PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 42], 'getStop', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new PlayStopStateTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[PlayStopStateTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[PlayStopStateTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new PlayStopStateTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([PlayStopStateTransformerInterface::KEY_VALUE => 'test-value', PlayStopStateTransformerInterface::KEY_PLAY => 'test-play', PlayStopStateTransformerInterface::KEY_STOP => 'test-stop']);

        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getValueType());
    }
}
