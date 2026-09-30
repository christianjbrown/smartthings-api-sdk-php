<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityCommand;
use ChristianBrown\SmartThings\Model\CommandArgumentInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CommandArgumentTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityCommand::class)]
#[CoversClass(CapabilityCommandTransformer::class)]
final class CapabilityCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $commandArgumentModel = self::createStub(CommandArgumentInterface::class);
        $commandArgumentTransformer = self::createStub(CommandArgumentTransformerInterface::class);
        $commandArgumentTransformer->method('transform')->willReturn($commandArgumentModel);
        $data = [
            CapabilityCommandTransformerInterface::KEY_NAME => 'test-name',
            CapabilityCommandTransformerInterface::KEY_ARGUMENTS => [['test-nested']],
            CapabilityCommandTransformerInterface::KEY_SENSITIVE => true,
        ];

        $transformer = new CapabilityCommandTransformer($commandArgumentTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame([$commandArgumentModel], $actual->getArguments());
        self::assertTrue($actual->getSensitive());
    }

    public function testTransformArguments(): void
    {
        $commandArgumentModel = self::createStub(CommandArgumentInterface::class);
        $commandArgumentTransformer = self::createStub(CommandArgumentTransformerInterface::class);
        $commandArgumentTransformer->method('transform')->willReturn($commandArgumentModel);
        $transformer = new CapabilityCommandTransformer($commandArgumentTransformer);
        $base = [CapabilityCommandTransformerInterface::KEY_NAME => 'test-name'];

        self::assertNull($transformer->transform($base)->getArguments());
        self::assertNull($transformer->transform($base + [CapabilityCommandTransformerInterface::KEY_ARGUMENTS => 'test-not-array'])->getArguments());
        self::assertSame([$commandArgumentModel], $transformer->transform($base + [CapabilityCommandTransformerInterface::KEY_ARGUMENTS => [['test-nested'], 'test-skipped']])->getArguments());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityCommandTransformer(self::createStub(CommandArgumentTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[CapabilityCommandTransformerInterface::KEY_NAME => 42], 'getName', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityCommandTransformer(self::createStub(CommandArgumentTransformerInterface::class));

        $actual = $transformer->transform([CapabilityCommandTransformerInterface::KEY_NAME => 'test-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'sensitiveAbsent' => [[], 'getSensitive', null];
        yield 'sensitiveWrongType' => [[CapabilityCommandTransformerInterface::KEY_SENSITIVE => 'not-bool'], 'getSensitive', null];
        yield 'sensitiveValid' => [[CapabilityCommandTransformerInterface::KEY_SENSITIVE => true], 'getSensitive', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $commandArgumentModel = self::createStub(CommandArgumentInterface::class);
        $commandArgumentTransformer = self::createStub(CommandArgumentTransformerInterface::class);
        $commandArgumentTransformer->method('transform')->willReturn($commandArgumentModel);
        $transformer = new CapabilityCommandTransformer($commandArgumentTransformer);

        $actual = $transformer->transform([CapabilityCommandTransformerInterface::KEY_NAME => 'test-name']);

        self::assertNull($actual->getArguments());
        self::assertNull($actual->getSensitive());
    }
}
