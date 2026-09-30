<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPad;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvDirectionalPadTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvDirectionalPad::class)]
#[CoversClass(BasicPlusTvDirectionalPadTransformer::class)]
final class BasicPlusTvDirectionalPadTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusTvDirectionalPadCommandModel = self::createStub(BasicPlusTvDirectionalPadCommandInterface::class);
        $basicPlusTvDirectionalPadCommandTransformer = self::createStub(BasicPlusTvDirectionalPadCommandTransformerInterface::class);
        $basicPlusTvDirectionalPadCommandTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadCommandModel);
        $data = [
            BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusTvDirectionalPadTransformerInterface::KEY_VERSION => 7,
            BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested'],
        ];

        $transformer = new BasicPlusTvDirectionalPadTransformer($basicPlusTvDirectionalPadCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame($basicPlusTvDirectionalPadCommandModel, $actual->getCommand());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvDirectionalPadTransformer(self::createStub(BasicPlusTvDirectionalPadCommandTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested']], 'getCapability', null];
        yield 'capabilityWrongType' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'componentAbsent' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested']], 'getComponent', null];
        yield 'componentWrongType' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'commandAbsent' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCommand', null];
        yield 'commandWrongType' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvDirectionalPadTransformer(self::createStub(BasicPlusTvDirectionalPadCommandTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusTvDirectionalPadTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusTvDirectionalPadCommandModel = self::createStub(BasicPlusTvDirectionalPadCommandInterface::class);
        $basicPlusTvDirectionalPadCommandTransformer = self::createStub(BasicPlusTvDirectionalPadCommandTransformerInterface::class);
        $basicPlusTvDirectionalPadCommandTransformer->method('transform')->willReturn($basicPlusTvDirectionalPadCommandModel);
        $transformer = new BasicPlusTvDirectionalPadTransformer($basicPlusTvDirectionalPadCommandTransformer);

        $actual = $transformer->transform([BasicPlusTvDirectionalPadTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvDirectionalPadTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getVersion());
    }
}
