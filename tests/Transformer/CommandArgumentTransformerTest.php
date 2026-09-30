<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandArgument;
use ChristianBrown\SmartThings\Transformer\CommandArgumentTransformer;
use ChristianBrown\SmartThings\Transformer\CommandArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommandArgument::class)]
#[CoversClass(CommandArgumentTransformer::class)]
final class CommandArgumentTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CommandArgumentTransformerInterface::KEY_NAME => 'test-name',
            CommandArgumentTransformerInterface::KEY_OPTIONAL => true,
            CommandArgumentTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'],
        ];

        $transformer = new CommandArgumentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertTrue($actual->getOptional());
        self::assertSame(['test-schema-key' => 'test-value'], $actual->getSchema());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CommandArgumentTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[CommandArgumentTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value']], 'getName', null];
        yield 'nameWrongType' => [[CommandArgumentTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value'], CommandArgumentTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'schemaAbsent' => [[CommandArgumentTransformerInterface::KEY_NAME => 'test-name'], 'getSchema', []];
        yield 'schemaWrongType' => [[CommandArgumentTransformerInterface::KEY_NAME => 'test-name', CommandArgumentTransformerInterface::KEY_SCHEMA => 'not-array'], 'getSchema', []];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CommandArgumentTransformer();

        $actual = $transformer->transform([CommandArgumentTransformerInterface::KEY_NAME => 'test-name', CommandArgumentTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'optionalAbsent' => [[], 'getOptional', null];
        yield 'optionalWrongType' => [[CommandArgumentTransformerInterface::KEY_OPTIONAL => 'not-bool'], 'getOptional', null];
        yield 'optionalValid' => [[CommandArgumentTransformerInterface::KEY_OPTIONAL => true], 'getOptional', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new CommandArgumentTransformer();

        $actual = $transformer->transform([CommandArgumentTransformerInterface::KEY_NAME => 'test-name', CommandArgumentTransformerInterface::KEY_SCHEMA => ['test-schema-key' => 'test-value']]);

        self::assertNull($actual->getOptional());
    }
}
