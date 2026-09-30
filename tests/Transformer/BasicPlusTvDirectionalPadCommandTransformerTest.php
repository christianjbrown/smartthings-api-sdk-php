<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommand;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadCommandTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvDirectionalPadCommand::class)]
#[CoversClass(BasicPlusTvDirectionalPadCommandTransformer::class)]
final class BasicPlusTvDirectionalPadCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_NAME => 'test-name',
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up',
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down',
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left',
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right',
            BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok',
        ];

        $transformer = new BasicPlusTvDirectionalPadCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-up', $actual->getUp());
        self::assertSame('test-down', $actual->getDown());
        self::assertSame('test-left', $actual->getLeft());
        self::assertSame('test-right', $actual->getRight());
        self::assertSame('test-ok', $actual->getOk());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvDirectionalPadCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'upAbsent' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok'], 'getUp', null];
        yield 'upWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 42], 'getUp', null];
        yield 'downAbsent' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok'], 'getDown', null];
        yield 'downWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 42], 'getDown', null];
        yield 'leftAbsent' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok'], 'getLeft', null];
        yield 'leftWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 42], 'getLeft', null];
        yield 'rightAbsent' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok'], 'getRight', null];
        yield 'rightWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 42], 'getRight', null];
        yield 'okAbsent' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right'], 'getOk', null];
        yield 'okWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 42], 'getOk', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvDirectionalPadCommandTransformer();

        $actual = $transformer->transform([BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BasicPlusTvDirectionalPadCommandTransformer();

        $actual = $transformer->transform([BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_UP => 'test-up', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_DOWN => 'test-down', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_LEFT => 'test-left', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_RIGHT => 'test-right', BasicPlusTvDirectionalPadCommandTransformerInterface::KEY_OK => 'test-ok']);

        self::assertNull($actual->getName());
    }
}
