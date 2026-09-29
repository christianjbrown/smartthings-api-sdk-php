<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandClasses;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformer;
use ChristianBrown\SmartThings\Transformer\CommandClassesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandClasses::class)]
#[CoversClass(CommandClassesTransformer::class)]
final class CommandClassesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CommandClassesTransformerInterface::KEY_EITHER => [1, 2],
            CommandClassesTransformerInterface::KEY_CONTROLLED => [1, 2],
            CommandClassesTransformerInterface::KEY_SUPPORTED => [1, 2],
        ];

        $transformer = new CommandClassesTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([1, 2], $actual->getEither());
        self::assertSame([1, 2], $actual->getControlled());
        self::assertSame([1, 2], $actual->getSupported());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CommandClassesTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'eitherAbsent' => [[], 'getEither', null];
        yield 'eitherWrongType' => [[CommandClassesTransformerInterface::KEY_EITHER => 'not-array'], 'getEither', null];
        yield 'eitherValid' => [[CommandClassesTransformerInterface::KEY_EITHER => [1, 2]], 'getEither', [1, 2]];
        yield 'controlledAbsent' => [[], 'getControlled', null];
        yield 'controlledWrongType' => [[CommandClassesTransformerInterface::KEY_CONTROLLED => 'not-array'], 'getControlled', null];
        yield 'controlledValid' => [[CommandClassesTransformerInterface::KEY_CONTROLLED => [1, 2]], 'getControlled', [1, 2]];
        yield 'supportedAbsent' => [[], 'getSupported', null];
        yield 'supportedWrongType' => [[CommandClassesTransformerInterface::KEY_SUPPORTED => 'not-array'], 'getSupported', null];
        yield 'supportedValid' => [[CommandClassesTransformerInterface::KEY_SUPPORTED => [1, 2]], 'getSupported', [1, 2]];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new CommandClassesTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getEither());
        self::assertNull($actual->getControlled());
        self::assertNull($actual->getSupported());
    }
}
