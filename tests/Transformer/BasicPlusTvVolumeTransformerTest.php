<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolume;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusTvVolumeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusTvVolume::class)]
#[CoversClass(BasicPlusTvVolumeTransformer::class)]
final class BasicPlusTvVolumeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandTransformer = self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class);
        $basicPlusTvVolumeCommandTransformer->method('transform')->willReturn($basicPlusTvVolumeCommandModel);
        $data = [
            BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusTvVolumeTransformerInterface::KEY_VERSION => 7,
            BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusTvVolumeTransformerInterface::KEY_LABEL => 'test-label',
            BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested'],
            BasicPlusTvVolumeTransformerInterface::KEY_VALUE => 'test-value',
            BasicPlusTvVolumeTransformerInterface::KEY_STEP => 1.5,
            BasicPlusTvVolumeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value'],
            BasicPlusTvVolumeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values',
        ];

        $transformer = new BasicPlusTvVolumeTransformer($basicPlusTvVolumeCommandTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame($basicPlusTvVolumeCommandModel, $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame(1.5, $actual->getStep());
        self::assertSame(['test-range-key' => 'test-value'], $actual->getRange());
        self::assertSame('test-supported-values', $actual->getSupportedValues());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvVolumeTransformer(self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested']], 'getCapability', null];
        yield 'capabilityWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'componentAbsent' => [[BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested']], 'getComponent', null];
        yield 'componentWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested'], BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'commandAbsent' => [[BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component'], 'getCommand', null];
        yield 'commandWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => 'not-array'], 'getCommand', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusTvVolumeTransformer(self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class));

        $actual = $transformer->transform([BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
        yield 'stepAbsent' => [[], 'getStep', null];
        yield 'stepWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_STEP => 'not-number'], 'getStep', null];
        yield 'stepValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_STEP => 1.5], 'getStep', 1.5];
        yield 'rangeAbsent' => [[], 'getRange', null];
        yield 'rangeWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_RANGE => 'not-array'], 'getRange', null];
        yield 'rangeValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_RANGE => ['test-range-key' => 'test-value']], 'getRange', ['test-range-key' => 'test-value']];
        yield 'supportedValuesAbsent' => [[], 'getSupportedValues', null];
        yield 'supportedValuesWrongType' => [[BasicPlusTvVolumeTransformerInterface::KEY_SUPPORTED_VALUES => 42], 'getSupportedValues', null];
        yield 'supportedValuesValid' => [[BasicPlusTvVolumeTransformerInterface::KEY_SUPPORTED_VALUES => 'test-supported-values'], 'getSupportedValues', 'test-supported-values'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusTvVolumeCommandModel = self::createStub(BasicPlusTvVolumeCommandInterface::class);
        $basicPlusTvVolumeCommandTransformer = self::createStub(BasicPlusTvVolumeCommandTransformerInterface::class);
        $basicPlusTvVolumeCommandTransformer->method('transform')->willReturn($basicPlusTvVolumeCommandModel);
        $transformer = new BasicPlusTvVolumeTransformer($basicPlusTvVolumeCommandTransformer);

        $actual = $transformer->transform([BasicPlusTvVolumeTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusTvVolumeTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusTvVolumeTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getValue());
        self::assertNull($actual->getStep());
        self::assertNull($actual->getRange());
        self::assertNull($actual->getSupportedValues());
    }
}
