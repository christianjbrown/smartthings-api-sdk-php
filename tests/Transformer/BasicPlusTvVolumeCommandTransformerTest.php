<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommand;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvVolumeCommand::class)]
#[CoversClass(BasicPlusTvVolumeCommandTransformer::class)]
final class BasicPlusTvVolumeCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BasicPlusTvVolumeCommandTransformerInterface::KEY_NAME => 'test-name',
            BasicPlusTvVolumeCommandTransformerInterface::KEY_INCREASE => 'test-increase',
            BasicPlusTvVolumeCommandTransformerInterface::KEY_DECREASE => 'test-decrease',
        ];

        $transformer = new BasicPlusTvVolumeCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-increase', $actual->getIncrease());
        self::assertSame('test-decrease', $actual->getDecrease());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvVolumeCommandTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'increaseAbsent' => [[], 'getIncrease', null];
        yield 'increaseWrongType' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_INCREASE => 42], 'getIncrease', null];
        yield 'increaseValid' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_INCREASE => 'test-increase'], 'getIncrease', 'test-increase'];
        yield 'decreaseAbsent' => [[], 'getDecrease', null];
        yield 'decreaseWrongType' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_DECREASE => 42], 'getDecrease', null];
        yield 'decreaseValid' => [[BasicPlusTvVolumeCommandTransformerInterface::KEY_DECREASE => 'test-decrease'], 'getDecrease', 'test-decrease'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BasicPlusTvVolumeCommandTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getIncrease());
        self::assertNull($actual->getDecrease());
    }
}
